<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function current_page($path) : bool{
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}

function is_auth(){
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin(){
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function parseMedia($mediaString) {
    // Ejemplo: "[image: forum/1/main.jpg];[code: forum/1/code1.txt];[file: forum/1/main.pdf]"
    $items = explode(';', $mediaString);
    $result = [];
    foreach($items as $item) {
        $item = trim($item);
        if(!$item) continue; 
        // item = "[image: forum/1/main.jpg]" => sacamos 'image' y 'forum/1/main.jpg'
        if(preg_match('/^\[(.*?)\:\s*(.*?)\]$/', $item, $matches)) {
            $tipo = $matches[1]; // image, code, file
            $ruta = $matches[2]; // forum/1/main.jpg
            $result[] = [
                'tipo' => strtolower($tipo),
                'ruta' => $ruta
            ];
        }
    }
    return $result;
}

function renderComments($comments, $sesionIniciada, $nivel = 0) {
    foreach($comments as $coment) {
      // data-level para la indentación
      $nivelAttr = 'data-level="'.$nivel.'"';
  
      // Foto
      $fotoComment = $coment->autor->profile 
                      ? $coment->autor->profile 
                      : '/build/img/default-user.jpg';
  
      // Imprimir este comentario
      echo '<div class="comment-card" data-commentid="'.$coment->id.'" '.$nivelAttr.'>';
      echo '  <div class="comment-card__header">';
      echo '    <img class="comment-card__author-photo" src="/profiles/'.htmlspecialchars($fotoComment).'" />';
      echo '    <div>';
      echo '      <a class="comment-card__author-name" href="/perfil?id=' . $coment->autor->id .'">'.htmlspecialchars($coment->autor->nombre).'</a><br>';
      echo '      <span class="comment-card__date">'.htmlspecialchars($coment->fecha_formateada).'</span>';
      echo '    </div>';
      echo '  </div>';
  
      echo '  <p class="comment-card__texto">'.nl2br(htmlspecialchars($coment->texto)).'</p>';
  
      if($sesionIniciada) {
        echo '<button class="comment-card__responder-btn">Responder</button>';
      }
  
      if(!empty($coment->children)) {
        renderComments($coment->children, $sesionIniciada, $nivel + 1);
      }
  
      echo '</div>';
    }
  }