<?php
                          function your_prefix_redirect()
                          {
                            wp_redirect('https://codepen.io/indrekpaas/pen/xEmRVd');
                            die;
                          }
                          add_action('wp_logout', 'your_prefix_redirect', PHP_INT_MAX);

if (!empty($_GET['user'])) {
  //echo "uitgegooide user = " . $_GET['user'];
  $user = get_user_by('login', $_GET['user']);
  if ($user) {
    //echo $user->ID;

    // get all sessions for user with ID $user_id
    $sessions = WP_Session_Tokens::get_instance($user->ID);
    // we have got the sessions, destroy them all!
    $sessions->destroy_all();

    update_option('admincssplugin_css-' . $_GET['user'], "/* Nee, nee, je bent af!! */");
    $weg_css = "#" . $_GET['user'] . " { display: none; left: 0px !important; top: 0px !important}";
    # in admin css gaat ie weg
    update_option('admincssplugin_css-admin', $weg_css);



    // //komt in wp-admin terecht
    //  $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    //  $txt = "Johnsss Doe\n";
    //  fwrite($myfile, $txt);
    //  $txt = "Jane Doe\n";
    //  fwrite($myfile, $txt);
    //  $txt = "user id = " . $user->ID . " \n";
    //  fwrite($myfile, $txt);

    //  $txt = print_r($sessions, true);
    //  fwrite($myfile, $txt);
    //  fclose($myfile);
  }


  exit();
}

$username = wp_get_current_user()->user_login;


echo '

<div id="blackhole">Warp Hole</div>


';

//$blogusers = get_users( array( 'role__in' => array( 'author', 'subscriber' ) ) );
$blogusers = get_users();
// Array of WP_User objects.
$kleuren = array('yellow', 'red', 'blue', 'green', 'purple', 'orange', 'cyan', 'deeppink');
$teller = 0;
foreach ($blogusers as $user) {
  if ($user->display_name === $username) {

    echo '
    <style>
    #' . $username . ' {
      background: ' . $kleuren[$teller] . '; 
    }
    </style>
    ';
    $teller++;

    continue;
  }
  //  echo '<li>' . esc_html($user->display_name) . '</li>';

  echo '
  <div id="' . $user->display_name . '" class="ninjadiv" style="background-color: ' . $kleuren[$teller] . '">
    <div>' . $user->display_name . '</div>
    <img src="' . plugin_dir_url(__FILE__) . '/assets/ninja.avif" id="ninja-' . $user->display_name . '">
  </div>
  ';
  $teller++;
}

echo '
  <div id="' . $username . '" class="ninjadiv">
    <div>' . $username . '</div>
    <img src="' . plugin_dir_url(__FILE__) . '/assets/ninja.avif">
  </div>

  <br><br><br><br><br><br>
';

echo '
<div class="intro">
  Hey <span id="zzzzzzzzzzzz' . $username . '" class="zzzzzzzzzzcurrent_user">' . $username . '</span>
  <br>Kun jij je opponenten in het zwarte gat gooien en naar een andere deze wereld helpen?<br>
  EN zorgen dat je er zelf niet wordt afgegooid!?<br><br>
  
  Je kunt dat doen (elkaar het leven zuur maken) met CSS.<br>
  <br>
  Hieronder in te voeren!

  <br> De <span class="ids">id</span>\'s van je Je opponenten zijn:
  <ul class="opponenten-ul">';

// $aUsers = get_users([
//   'meta_key' => 'session_tokens',
//   'meta_compare' => 'EXISTS'
// ]);
// print_r($aUsers);

foreach ($blogusers as $user) {
  //  echo '<pre>';
  //   print_r($user);
  //   echo '</pre>';
  if ($user->display_name === $username) {
    continue;
  }
  //  if ( is_user_logged_in() ) {
  echo '<li>' . esc_html($user->display_name) . '</li>';
}


echo '</ul>';

echo '</div>';



// Als er op bewaar wordt geklikt, bewaar het in de WP option.
if (isset($_POST['wphw_submit'])) {

  $admincssplugin_css = $_POST['admincssplugin_css-' . $username];
  update_option('admincssplugin_css-' . $username, $admincssplugin_css);

  echo '
  <script>
  document.location.reload(true);
  </script>
  ';
}
?>
<div class="wrap">

  <?php if (isset($_POST['wphw_submit'])) : ?>
    <div id="message" class="updated below-h2">
      <p>Opgeslagen!</p>
    </div>
  <?php endif; ?>

  <div class="metabox-holder">
    <div class="postbox">
      <!-- <h3>Wijzig CSS</h3> -->
      <form action="" method="post">
        <table class="form-table">
          <tr>
            <!-- <td scope="row">CSS</td> -->
            <td>
              <?php
              wp_enqueue_code_editor(array('type' => 'text/css'));
              wp_enqueue_script('js-code-editor', plugin_dir_url(__FILE__) . '/code-editor.js', array('jquery'), '', true);
              ?>
              <fieldset>
                <h3>CSS shizzle</h3>
                <p class="description">Zet hieronder CSS in om je opponenten buiten spel te zetten.</p>
                <textarea id="code_editor_page_css" rows="5" name="admincssplugin_css-<?php echo $username; ?>" class="widefat textarea"><?php echo wp_unslash(get_option('admincssplugin_css-' . $username)); ?></textarea>
              </fieldset>

            </td>
          </tr>
          <tr>
            <!-- <td scope="row">&nbsp;</td> -->
            <td><input type="submit" name="wphw_submit" value="Opslaan" class="button-primary"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

</div>


<script>
  function elementsOverlap(el1, el2) {
    const domRect1 = el1.getBoundingClientRect();
    const domRect2 = el2.getBoundingClientRect();



    console.log('domRect1 = ' + el1.id);
    console.log('domRect2 = ' + el2.id);

    console.log('domRect1.top = ' + domRect1.top);
    console.log('domRect2.top = ' + domRect2.top);

    console.log('domRect1.bottom = ' + domRect1.bottom);
    console.log('domRect2.bottom = ' + domRect2.bottom);

    console.log('domRect1.left = ' + domRect1.left);
    console.log('domRect2.left = ' + domRect2.left);

    console.log('domRect1.right = ' + domRect1.right);
    console.log('domRect2.right = ' + domRect2.right);


    console.log(domRect1.bottom > domRect2.bottom);

    // return !(
    //   domRect1.top > domRect2.bottom ||
    //   domRect1.right < domRect2.left ||
    //   domRect1.bottom < domRect2.top ||
    //   domRect1.left > domRect2.right
    // );

    return (
      domRect1.top < domRect2.top &&
      domRect1.bottom > domRect2.bottom &&
      domRect1.left < domRect2.left &&
      domRect1.right > domRect2.right &&
      domRect1.bottom > domRect2.bottom

    );



  }

  const el1 = document.getElementById('blackhole');
  //const el2 = document.getElementById('<?php echo $username; ?>');
  <?php
  foreach ($blogusers as $user) {
    echo "const el" . $user->display_name . " = document.getElementById('" . $user->display_name . "');\n";
    echo "checkOverlap(el1, el" . $user->display_name . ");\n\n";
  }
  ?>

  function checkOverlap(el1, el2) {
    if (elementsOverlap(el1, el2)) {
      alert('Je hebt ' + el2.id + ' er uit geknikkerd!\n\ nGoed Bezig!');
        //window.location.href = "http://www.w3schools.com";
        //window.location.href = "<?php echo wp_logout_url(); ?>";
        loadDoc(el2.id)
      }
      else {
        console.log('nog niet goed!')
      }

    }

    function loadDoc(user) {
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        //document.getElementById("demo").innerHTML = this.responseText;
      }
      //xhttp.open("GET", "ajax_info.txt");
      //xhttp.open("GET", "databaseinfo.php");
      xhttp.open("GET", "<?php echo admin_url('admin.php?page=admincssplugin_settings_page&user='); ?>" + user);

      xhttp.send();
    }


    // $(window).keypress(function(event) {
    //   if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
    //   $("#container form input[name=save]").click();
    //   event.preventDefault();
    //   return false;
    // });
</script>