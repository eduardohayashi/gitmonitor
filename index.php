<?php 

function getColor($type = 'good') {
    $colors =  [
      'good'    => '#2efe2e',
      'info'    => '',
      'warning' => '',
      'alert'   => '#ff0000',
    ];

    if (array_key_exists($type, $colors)) {
        return $colors[$type];
    }

    return ;
}

function getRepositories() {
    $file = "repositories.json";
    return json_decode(file_get_contents($file), true);
}

function getUntrackedFIles($path) {
    $output = "";
    $command = "./git-monitor.sh untracked " . $path;
    exec($command, $output);
    if ($output) {
        return $output;
    }

    return ;
}

function getChangedFiles($path) {
    $output = "";
    $command = "./git-monitor.sh changed " . $path;
    exec($command, $output);
    if ($output) {
        return $output;
    }

    return ;
}

?>
<html>
<meta http-equiv="refresh" content="300">
<body>
  <?php
      echo "(Auto-reload - 300 segundos)<br>\n";
      date_default_timezone_set('UTC');
      echo date('Y-m-d H:i:s');
  ?>
  <h1></h1>
  <h2>GIT repositories</h2>
  <br><hr><br>

  <table><tr>
  <?php
  $output = "";
  $count = 1;
  $repositories = getRepositories();
  
  foreach ($repositories as $repo=>$path) {
      $changedFiles = getChangedFiles($path);
      $untrackedFiles = getUntrackedFiles($path);

      if (empty($changedFiles)){
          $color = getColor('good');
      } else {
          $color = getColor('alert');
      }
      
      echo "<td bgcolor='" . $color . "' valign='top'>";
      echo "<b>" . $repo . "</b><br>";
        foreach ($changedFiles as $line) {
            echo preg_replace('(\w+\/)', '.../', $line) . "<br>";
        }
      echo "</td>";
      
      if ($count%2==0) {
          echo "</tr><tr>";
      }
      
      $count++;    
  }
  ?>
  <tr></table>
</body></html>
