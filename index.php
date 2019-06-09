<?php
 /*
 Project phonebook
 @Author NottDev 07/06/19
 */

require 'vendor/autoload.php';

$storage = new Flatbase\Storage\Filesystem('./models');
$flatbase = new Flatbase\Flatbase($storage);
$rows = $flatbase->read()->in('phonebook')->get();

?>

<?php require ('header.php'); ?>

<!-- Main -->
<main role="main" class="container">
  <div class="align-items-center p-3 my-3 mt-5 text-white-50 bg-primary rounded shadow-sm"
    style="margin-top: 70px!important;">
    <div class="d-flex align-items-center">
      <h5 class="mb-0 text-white lh-100 mr-auto">Contacts</h5>
      <button type="button" onclick="window.location.href = 
          'form.php'" class="btn btn-light btn-sm float-right shadow"><i class="fa fa-plus"></i> Contact</button>
    </div>
  </div>
  <div class="my-3 p-3 bg-white rounded shadow">
    <? $i = 0; foreach ($rows  as $key => $value) { $i++; ?>
    <div class="text-muted pt-3 border-bottom p-3">
      <div class="d-flex align-items-center">
        <div class="mr-4">
          <div class="rounded-circle d-inline-block border border-secondary text-center shadow"
            onclick="window.location.href='edit.php?id=<?= $value['id'] ?>'">
            <img class="rounded-circle"
              src="<?= (!empty($value['profileImg'])?'uploads/'.$value['profileImg']:'dist/img/profile-default.jpg') ?>"
              alt="profile" srcset="" width="60px" height="60px" />
          </div>
        </div>
        <div class="mr-auto">
          <p class="mb-0 h5" style="font-weight: lighter;"><strong></strong> <?= $value['name'];?></p>
          <p class="mb-0" style="font-weight: lighter;">
            <strong><i class="fa fa-phone" aria-hidden="true"></i> </strong>
            <a href="tel:<?= $value['tel'];?>"><?= $value['tel'];?></a>
          </p>
        </div>
        <div class="text-right">
          <button type="button" onclick="window.location.href='edit.php?id=<?= $value['id'] ?>'"
            class="d-block btn btn-sm btn-default shadow-sm mb-1"><i class="fa  fa-edit"></i> Edit</button>
          <button type="button" onclick="window.location.href='controllers/delete.php?id=<?= $value['id'] ?>'"
            class="d-block btn btn-sm btn-default shadow-sm"> <i class="fa  fa-trash"></i> Delete</button>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if(!$i) { ?>
    <div class="text-center"> No item</div>
    <?php } ?>
  </div>
</main>
<!-- /Main -->

<?php require "footer.php"; ?>