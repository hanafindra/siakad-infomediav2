<hr>
<div class="row">
  <div class="col-md-2">
    <a href="<?php echo site_url('admin/noticeboard/');?>"
      class="btn btn-default btn-block">
      <?php echo get_phrase('papan_pengumuman'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/events');?>"
      class="btn btn-<?php echo $page_content == 'frontend_events' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('kegiatan'); ?>
    </a>
    <a href="<?php echo site_url('admin/teacher');?>"
      class="btn btn-default btn-block">
      <?php echo get_phrase('guru'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/gallery');?>"
      class="btn btn-<?php echo ($page_content == 'frontend_gallery' || $page_content == 'frontend_gallery_image') ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('galeri'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/about_us');?>"
      class="btn btn-<?php echo $page_content == 'frontend_about_us' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('tentang_kami'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/terms_conditions');?>"
      class="btn btn-<?php echo $page_content == 'frontend_terms_conditions' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('syarat & ketentuan'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/privacy_policy');?>"
      class="btn btn-<?php echo $page_content == 'frontend_privacy_policy' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('kebijakan_privasi'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/homepage_slider');?>"
      class="btn btn-<?php echo $page_content == 'frontend_slider' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('pergeseran_halaman_awal'); ?>
    </a>
    <a href="<?php echo site_url('admin/frontend_pages/general');?>"
      class="btn btn-<?php echo $page_content == 'frontend_general_settings' ? 'primary' : 'default'; ?> btn-block">
      <?php echo get_phrase('pengaturan_umum'); ?>
    </a>
  </div>
  <div class="col-md-10">
    <?php include $page_content.'.php'; ?>
  </div>
</div>
