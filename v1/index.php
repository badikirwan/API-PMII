<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/22/17
 * Time: 7:55 AM
 */

use \Slim\Http\Request;
use \Slim\Http\Response;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/src/config.php';

$app = new \Slim\App();
$con = getDB();

$app->post('/login', function (Request $request, Response $response) use ($con, $app) {
    $username = $request->getParam('username');
    $password = md5($request->getParam('password'));
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $stmt = $con->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $response->withJson(['status' => 'success', 'data' => [$result]], 200);
    } else {
        return $response->withJson(['status' => 'error', 'data' => 'user tidak ditemukan..'], 200);
    }

});

/**
 * Mengambil semua data anggota yang berstatus 'kader aktif'
 * Method GET
 **/
$app->post('/verifikasi/', function (Request $request, Response $response) use ($con) {
    $komisariat = $request->getParam('komisariat');
    $query = "SELECT * FROM anggota WHERE sts_anggota LIKE 'kader aktif' AND status = '1' AND komisariat= '$komisariat' ORDER BY nama ASC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson(['status' => 'success', 'count' => $count, 'data' => $result], 200);
});

$app->post('/cari/', function (Request $request, Response $response) use ($con) {
    $cari = $request->getParam('cari');
    $query = "SELECT * FROM anggota WHERE nama LIKE '%".$cari."%'";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson(['status' => 'success', 'count' => $count, 'data' => $result], 200);
});

/**
 * Mengambil semua data anggota yang berstatus 'kader aktif'
 * Method GET
 **/
$app->post('/anggotaaktif/', function (Request $request, Response $response) use ($con) {
    $komisariat = $request->getParam('komisariat');
    $query = "SELECT * FROM anggota WHERE sts_anggota LIKE 'kader aktif' AND status = '2' AND komisariat= '$komisariat' ORDER BY nama ASC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson(['status' => 'success', 'count' => $count, 'data' => $result], 200);
});

/**
 * Mengambil semua data anggota yang berstatus 'alumni'
 * Method GET
 **/
$app->get('/anggota/alumni', function (Request $request, Response $response) use ($con) {
    $query = "SELECT * FROM anggota WHERE sts_anggota='alumni'";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson(['status' => 'success', 'count' => $count, 'data' => $result], 200);
});

/**
 * Mengambil semua data komisariat
 * Method GET
 **/
$app->get('/komisariat/', function (Request $request, Response $response) use ($con) {
    $query = "SELECT * FROM komisariat";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response->withJson(['status' => 'success', 'count' => $count, 'data' => $result], 200);
});

/**
 * Mengambil data komisariat sesuia id
 * Method GET
 **/
$app->get('/komisariat/{id}', function (Request $request, Response $response) use ($con) {
    $id = $request->getAttribute('id');
    $query = "SELECT * FROM komisariat WHERE id_kom=:id";
    $stmt = $con->prepare($query);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch();

    if ($result) {
        return $response->withJson(['status' => 'success', 'data' => $result], 200);
    } else {
        return $response->withJson(['status' => 'failed', 'data' => $result], 422);
    }
});

/**
 * Menambhkan data baru komisariat
 * Method POST
 **/
$app->post('/komisariat', function (Request $request, Response $response) use($con) {
    $angota = $request->getParsedBody();
    $query = "INSERT INTO komisariat(nama, keterangan) VALUES(:nama, :keterangan)";
    $stmt = $con->prepare($query);

    $data = [
        ':nama' => $angota['nama'],
        ':keterangan' => $angota['keterangan']
    ];

    if ($stmt->execute($data)) {
        return $response->withJson(['status' => 'success', 'data' => '1'], 200);
    } else {
        return $response->withJson(['status' => 'failed', 'data' => '0'], 422);
    }
});

/**
 * Merubah data komisariat sesuai id
 * Method PUT
 **/
$app->put('/komisariat/{id}', function (Request $request, Response $response, $args) use ($con) {
    $id = $args['id'];
    $komisariat = $request->getParsedBody();
    $query = "UPDATE komisariat SET nama=:nama, keterangan=:keterangan WHERE id_kom=:id";
    $stmt = $con->prepare($query);

    $data = [
        ':id' => $id,
        ':nama' => $komisariat['nama'],
        ':keterangan' => $komisariat['keterangan']
    ];

    if ($stmt->execute($data)) {
        return $response->withJson(['status' => 'success', 'data' => '1'], 200);
    } else {
        return $response->withJson(['status' => 'failed', 'data' => '0'], 422);
    }
});

/**
 * Menghapus data komisariat sesuai id
 * Method DELETE
 **/
$app->delete('/komisariat/{id}', function (Request $request, Response $response) use($con) {
    $id = $request->getAttribute('id');
    $query = "DELETE FROM komisariat WHERE id_kom=:id";
    $stmt = $con->prepare($query);

    if ($stmt->execute([':id' => $id])) {
        return $response->withJson(['status' => 'success', 'data' => '1'], 200);
    } else {
        return $response->withJson(['status' => 'failed', 'data' => '0'], 422);
    }
});

$app->run();