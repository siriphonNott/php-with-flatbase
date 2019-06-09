<?php require ('header.php'); ?>

<!-- Main -->
<main role="main" class="container">
  <div class="align-items-center p-3 my-3 mt-5 text-white-50 bg-primary rounded shadow-sm"
    style="    margin-top: 70px!important;">
    <div class="d-flex align-items-center">
      <h5 class="mb-0 text-white lh-100 mr-auto">Add Contact</h5>
      <button type="button" onclick="window.location.href = 
          'index.php'" class="btn btn-light btn-sm float-right shadow"><i class="fa fa-chevron-left"></i> Back</button>
    </div>
  </div>
  <div class="my-3 p-3 bg-white rounded shadow clearfix">
    <form action="controllers/insert.php" method="POST" autocomplete="off" enctype="multipart/form-data">
      <input type="file" class="d-none" name="fileUpload" accept="image/png,image/jpg,image/jpeg">
      <div class="row text-center">
        <div class="col-md-12 p-3">
          <div class="rounded-circle d-inline-block border border-secondary profileImg position-relative shadow">
            <img class="rounded-circle" src="dist/img/profile-default.jpg" alt="profile" srcset="" />
            <span>Edit</span>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="validationDefault01">Name</label>
          <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
            placeholder="Enter Name" required />
        </div>
        <div class="col-md-6 mb-3">
          <label for="validationDefault02">Phone number</label>
          <input type="number" class="form-control" id="tel" name="tel" maxlength="10" placeholder="999 999 9999"
            oninput="maxLengthCheck(this)" required />
        </div>
      </div>
      <button type="submit" class="btn btn-primary float-right mb-3 shadow">Submit</button>
    </form>
  </div>
</main>
<!-- /Main -->

<?php require "footer.php"; ?>