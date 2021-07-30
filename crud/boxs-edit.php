<?php

function lw_boxs_edit() {
    // global $wpdb;
    // $post_id = $_GET["box_id"];
//update
    if (isset($_POST['update'])) {
        // $wpdb->update(
        //         $table_name, //table
        //         array('name' => $name), //data
        //         array('ID' => $id), //where
        //         array('%s'), //data format
        //         array('%s') //where format
        // );
    }
//delete
    else if (isset($_POST['delete'])) {
        // $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
        wp_delete_post($_GET["box_id"], true);
    } else {//selecting value to update	
        // $schools = $wpdb->get_results($wpdb->prepare("SELECT id,name from $table_name where id=%s", $id));
        // foreach ($schools as $s) {
        //     $name = $s->name;
        // }
        $post = get_post( $_GET["box_id"] );
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Caja</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Caja Eliminada</p></div>
            <a href="<?php echo admin_url('admin.php?page=cajas') ?>">&laquo; Volver a la lista</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>School updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=sinetiks_schools_list') ?>">&laquo; Back to schools list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Title</th><td><input type="text" name="name" value="<?php echo $post->post_title; ?>"/></td></tr>
                </table>
                <br>
                <input type='submit' name="update" value='Guardar' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Eliminar' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                <a href="<?php echo admin_url('admin.php?page=cajas'); ?>" class='button'> Volver</a>
            </form>
        <?php } ?>

    </div>
    <?php
}