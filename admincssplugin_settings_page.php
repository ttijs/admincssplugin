<?php
// Als er op bewaar wordt geklikt, bewaar het in de WP option.
if (isset($_POST['wphw_submit'])) {

  $admincssplugin_css = $_POST['admincssplugin_css'];
  update_option('admincssplugin_css', $admincssplugin_css);

}
?>
<div class="wrap">

  <h2>Beheer CSS</h2>

  <?php if (isset($_POST['wphw_submit'])) : ?>
    <div id="message" class="updated below-h2">
      <p>Opgeslagen!</p>
    </div>
  <?php endif; ?>

  <div class="metabox-holder">
    <div class="postbox">
      <h3>Wijzig CSS</h3>
      <form action="" method="post">
        <table class="form-table">
          <tr>
            <td scope="row">CSS</td>
            <td>
              <?php
              wp_enqueue_code_editor(array('type' => 'text/css'));
              wp_enqueue_script('js-code-editor', plugin_dir_url(__FILE__) . '/code-editor.js', array('jquery'), '', true);
              ?>
              <fieldset>
                <h3>CSS</h3>
                <p class="description">Geef hieronder CSS in</p>
                <textarea id="code_editor_page_css" rows="5" name="admincssplugin_css" class="widefat textarea"><?php echo wp_unslash(get_option('admincssplugin_css')); ?></textarea>
              </fieldset>

            </td>
          </tr>
          <tr>
            <td scope="row">&nbsp;</td>
            <td><input type="submit" name="wphw_submit" value="Opslaan" class="button-primary"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

</div>