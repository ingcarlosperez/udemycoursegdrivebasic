<?php
require "credenciales.php";
// Listar archivos
error_reporting(E_ALL);
ini_set('display_errors', 1);
function listarArchivos($service, $optParams)
{
    $results = $service->files->listFiles($optParams);

    if (count($results->getFiles()) == 0) {
        print "No files found.\n";
    } else {
        print "Files:\n";
        foreach ($results->getFiles() as $file) {
            printf("%s (%s)\n", $file->getName(), $file->getId());
        }
    }
}

//Buscar archivos
function buscarArchivos($service)
{
    $pageToken = null;
    do {
          $response = $service->files->listFiles(array(
        'q' => "mimeType='image/jpeg' and name contains '000_0616'",
        'spaces' => 'drive',
        'pageToken' => $pageToken,
        'fields' => 'nextPageToken, files(id, name)'
          ));
        foreach ($response->files as $file) {
              printf("Found file: %s (%s)\n", $file->name, $file->id);
        }
    } while ($pageToken != null);
}

//Descargar archivos
function descargarArchivos($service)
{
    $fileId = '0BxCE9YuyKsNoWlBWTk9veFpJcGs';
    $responseMetada = $service->files->get($fileId);
    $response = $service->files->get($fileId, array(
    'alt' => 'media' ));
    $content = $response->getBody()->getContents();
    
   file_put_contents("hola1.jpg",   $content);
}

//Buscar archivos
function subirArchivos($service)
{

    $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => 'image.jpg'));
    $content = file_get_contents('files/image.jpg');
    $file = $driveService->files->create($fileMetadata, array(
    'data' => $content,
    'mimeType' => 'image/jpeg',
    'uploadType' => 'multipart',
    'fields' => 'id'));
    printf("File ID: %s\n", $file->id);
}
// listarArchivos($service, $optParams);
// buscarArchivos($service);
// descargarArchivos($service);
// subirArchivos($service);

