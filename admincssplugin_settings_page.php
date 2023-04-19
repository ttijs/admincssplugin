<?php


$username = wp_get_current_user()->user_login;


echo '

<div id="blackhole">Warp Hole</div>
<style>
  #blackhole {
    width: 300px;
    height: 150px;
    background-color: black;
    margin: 0 auto;
    position: relative;
    top: 0px;
    text-align: center;
    color: white;

  }

.current_user {
}

.ninjadiv {
  padding: 5px;
  color: white;
  width: 50px;
  text-align: center;

  position: absolute;
}
.ninjadiv img {
  width: 100%;
}

.opponenten-ul li {
  /*display: inline-block; margin-right: 5px;*/
} 

</style>


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

foreach ($blogusers as $user) {
  if ($user->display_name === $username) {
    continue;
  }
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

    console.log('domRect1.top = ' + domRect1.top);
    console.log('domRect2.bottom = ' + domRect2.bottom);

    console.log('domRect1.right = ' + domRect1.right);
    console.log('domRect2.left = ' + domRect2.left);

    console.log('domRect1.bottom = ' + domRect1.bottom);
    console.log('domRect2.top = ' + domRect2.top);

    console.log('domRect1.left = ' + domRect1.left);
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
  const el2 = document.getElementById('<?php echo $username; ?>');

  if (elementsOverlap(el1, el2)) {
    alert('Je bent er uit geknikkerd!\n\nDOE!');
    //window.location.href = "http://www.w3schools.com";
    window.location.href = "<?php echo wp_logout_url(home_url()); ?>";
    

  } else {
    console.log('nog niet goed!')
  }
</script>