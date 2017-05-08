<?php
  if (!empty($_GET['q'])) {
    switch ($_GET['q']) {
      case 'info':
        phpinfo();
        exit;
      break;
    }
  }

  function get_icon($folder){
    $locations = ["favicon.ico","favicon.png","images/favicon.ico","img/favicon.ico","assets/img/favicon.ico"];
    foreach ($locations as $location) {
      if(file_exists($folder."/".$location)) {
						return $folder."/".$location;
			}
    }
  }
  $rootDir = opendir("."); // open current directory
  $dirArray = array();
  // get each entry
  while($element = readdir($rootDir)) {
    // exclude files and hidden folders
    if (is_dir($element) && (substr($element, 0, 1) != ".")) {
      $dirArray[] = $element;
    }
  }
  closedir($rootDir);                         // close directory
  $projectCount = count($dirArray) ;          // count elements in array
  if ($projectCount > 0) { sort($dirArray); } // sort 'em
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Localhost/</title>
        <meta name="description" content="DESCRIPTION">
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href='//cdn.jsdelivr.net/devicons/1.8.0/css/devicons.min.css' rel='stylesheet'>
        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
        <style>
            .tabs .indicator {
                background-color: #ba68c8;
            }
        </style>
        <!--[if lt IE 9]>
       <script src = "http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
     <![endif]-->
    </head>

    <body>
        <nav class="purple darken-2" role="navigation">
            <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Localhost</a>
                <ul class="right hide-on-med-and-down">
                    <li><a target="_blank" href="/?q=info">PHP info</a></li>
                </ul>
            </div>
        </nav>
        <div class="section no-pad-bot" id="index-banner">
            <div class="container">
                <br><br>
                <!-- <h2 class="header left-align purple-text">Welcome User :</h2>-->
                <div class="row left-align">
                    <h5 class="header col s12 light">Welcome developer :</h5>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="card">
                        <div class="card-content">
                            <h4>Server Summary : <b><?= $_SERVER['SERVER_NAME']; ?></b></h4>
                        </div>
                        <div class="card-tabs">
                            <ul class="tabs tabs-fixed-width">
                                <li class="tab"><a class="purple-text text-lighten-3" href="#soft">Server Software</a></li>
                                <li class="tab"><a class="purple-text text-lighten-3 active" href="#php">PHP Version</a></li>
                                <li class="tab"><a class="purple-text text-lighten-3" href="#root">Projects (<b><?php echo ($projectCount > 0)? $projectCount : "No"; ?></b>) </a></li>
                            </ul>
                        </div>
                        <div class="card-content grey lighten-4">
                            <div id="soft">
                                <?= $_SERVER['SERVER_SOFTWARE']; ?>
                                <hr>
                                <?php
                                echo "<table border = '2' style='color:#ffffff;'>";
                                $i = 0;
                                foreach($_SERVER as $key=>$value){
                                if($i%2 == 0) {
                                echo "<tr bgcolor='#993300'>";
                                } else {
                                echo "<tr bgcolor='#0099FF'>";
                                }
                                echo "<td>";
                                echo $key;
                                echo "</td>";
                                echo "<td>";
                                echo $value;
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                                }
                                echo "</table>";
                                 ?>
                            </div>
                            <div id="php">
                                <ul class="collection">

                                    <li class="collection-item avatar">
                                        <i class="devicons devicons-php circle deep-purple"></i>
                                        <span class="title">PHP version</span>
                                        <p><span>Check <a title="phpinfo()" target="_blank" href="/?q=info">info</a></span> </p>
                                        <a href="#!" class="secondary-content"><span class="new badge" data-badge-caption="<?= phpversion(); ?>">V</span></a>
                                    </li>

                                </ul>
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header"><i class="material-icons">explicit</i> PHP Extensions</div>
                                        <div class="collapsible-body">
                                            <ul>
                                                <?php
                                                  $extensions = get_loaded_extensions();
                                                  natcasesort($extensions);
                                                  foreach($extensions as $extention):
                                                ?>
                                                    <li><?= $extention; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header"><i class="material-icons">settings</i> INI Settings</div>
                                        <div class="collapsible-body">
                                            <?php
                                              $inipath = php_ini_loaded_file();
                                              if ($inipath) {
                                                  echo '<p>Loaded php.ini: <a href="'.$inipath.'" target="_blank">'.$inipath.'</a></p>';
                                              } else {
                                                  echo 'A php.ini file is not loaded';
                                              }

                                              echo '- Display_errors = ' . ini_get('display_errors') . "<br />";
                                              echo '- Post_max_size = ' . ini_get('post_max_size') . "<br />";
                                              echo '- Upload_max_filesize = ' . ini_get('upload_max_filesize');
                                           ?>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div id="root">Document Root: <b><?= $_SERVER['DOCUMENT_ROOT']); ?></b><br />
                                <ul class="collection">
                                    <?php
                                    if ($projectCount > 0) :
                                      foreach ($dirArray as $dir):
                                        $modtime=date("M j, Y, g:i A", filemtime($dir));
                                    ?>
                                    <li class="collection-item avatar">
                                        <?php if(get_icon($dir) != null){?>
                                        <img src="<?= get_icon($dir); ?>" alt="" class="circle">
                                        <?php }else{ ?>
                                        <i class="material-icons circle">folder</i>
                                        <?php } ?>
                                        <span class="title"><?= $dir ;?></span>
                                        <p>Last mofied at : <b><?= $modtime; ?></b></p>
                                        <a href="http://localhost/<?= $dir ;?>" target="_blank" class="secondary-content"><i class="material-icons">open_in_new</i></a>
                                    </li>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <br><br>

            <div class="section">

            </div>
        </div>

        <footer class="page-footer green accent-2">


            <div class="footer-copyright">
                <div class="container">
                    Made by <a class="purple-text text-lighten-3" href="https://stormix.co">Stormix</a>
                </div>
            </div>
        </footer>

        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>

    </body>

    </html>
