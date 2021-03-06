<?php

function lw_compras_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/loginweb/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Compras</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page='); ?>">Agregar Nueva</a>
            </div>
            <br class="clear">
        </div>
        <?php
        $args = array(
            'post_type'        => 'lw_compras'
        );
        $rows = get_posts( $args );
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">ID</th>
                <th class="manage-column ss-list-width">Titulo</th>
                <th class="manage-column ss-list-width">Creado</th>
                <th class="manage-column ss-list-width">Usuario</th>
                <th class="manage-column ss-list-width">Acciones</th>
            </tr>
            <?php for($i=0; $i < count($rows); $i++){ $user = get_user_by( 'id', $rows[$i]->post_author ); ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->ID; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $rows[$i]->post_title; ?></td>
                    <td class="manage-column ss-list-width"><?php echo  $rows[$i]->post_date; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $user->display_name; ?></td>
                    
                    <td><a href="<?php echo admin_url('admin.php?page=' . $row->id); ?>">Actualizar</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}