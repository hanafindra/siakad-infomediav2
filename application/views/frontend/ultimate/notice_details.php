<?php
  $notice_details = $this->db->get_where('noticeboard', array('id' => $notice_id))->row_array();
?>
<!-- ========== MAIN ========== -->
<main id="content" role="main">
  <!-- Hero Section -->
  <div class="gradient-half-primary-v1">
    <div class="container text-center space-top-4 space-top-md-4 space-top-lg-3 space-bottom-1">
      <!-- Title -->
      <div class="w-md-80 w-lg-50 mx-auto mb-5">
        <h1 class="h1 text-white">
<<<<<<< HEAD
          <span class="font-weight-semi-bold"><?php echo get_phrase('Noticeboard'); ?></span>
=======
          <span class="font-weight-semi-bold">Papan Pengumuman</span>
>>>>>>> e5e243259b5018699de5cc135fabe25e8846865a
        </h1>
      </div>
      <!-- End Title -->
    </div>
  </div>
  <!-- End Hero Section -->


  <div class="container space-top-2 space-top-md-2">
<<<<<<< HEAD
    <div class="row">
      <div class="col-md-6">
        <!-- Link -->
        <div class="space-bottom-0 space-bottom-md-0">
          <a class="text-secondary" href="<?php echo site_url('home/noticeboard');?>">
            <span class="fas fa-arrow-left small mr-2"></span>
            <?php echo get_phrase('Back to noticeboard'); ?>
          </a>
        </div>
        <!-- End Link -->
=======
  <?php foreach ($info as $row) : ?>
  <div class="row">
    <div class="col-md-6">
      <!-- Link -->
      <div class="space-bottom-0 space-bottom-md-0">
        <a class="text-secondary" href="<?php echo site_url('home/noticeboard');?>">
          <span class="fas fa-arrow-left small mr-2"></span>
          Kembali ke Papan Pengumuman
        </a>
      </div>
      <!-- End Link -->
>>>>>>> e5e243259b5018699de5cc135fabe25e8846865a


        <!-- Info -->
        <div class="mb-4">
          <h1 class="text-primary font-weight-semi-bold">
            <?php echo $notice_details['notice_title']; ?>
          </h1>
        </div>
        <!-- End Info -->
        <p>
          <?php echo date('d M, Y', strtotime($notice_details['date'])); ?>
        </p>
        <p>
          <?php echo $notice_details['notice']; ?>
        </p>
      </div>

      <div class="col-md-6">
        <!-- SVG Mockup -->
        <figure class="ie-ellipse-mockup">
          <img class="js-svg-injector" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/svg/illustrations/ellipse-mockup.svg" alt="Image Description"
               data-img-paths='[
                 {"targetId": "#SVGellipseMockupImg1", "newPath": "<?php echo $this->crud_model->get_noticeboard_image($notice_details['image']); ?>"}
               ]'
               data-parent="#SVGellipseMockup">
        </figure>
        <!-- End SVG Mockup -->
      </div>
    </div>
  </div>

</main>
<!-- ========== END MAIN ========== -->
