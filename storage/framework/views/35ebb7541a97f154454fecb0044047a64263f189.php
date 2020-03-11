<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(count($section->gallery) !=0): ?>
<div class="row justify-content-center border-bottom border-secondary">
  <h4 class="w-100 px-3 pt-2"><?php echo e($section->title); ?></h4>
  <div class="col-md-10">
    <div class="row">

      <div class="col-md-2" style="margin-top:10px">
        <div class="item text-center h-105" style="width:51%;">
          <div class="rounded overflow-hidden bg-secondary ptpb-2" style="border: 2px solid white;background-color: #5f5d5d !important;">
            <!-- <a href="<?php echo e(url('dashboard/gallery/add-content/'.$section->id)); ?>"><i class="fa fa-plus-circle fa-2x text-white mt-2"></i></a> -->
            <a href="<?php echo e(url('dashboard/gallery/add-content/'.$section->id)); ?>"><i class="material-icons text-white" style="font-size: 28px;">add_circle</i></a>
          </div>
        </div>
      </div>
    <div class="col-md-10">
    <div class="">

      <div id="gallery">
        <div id="image-container" style="width: 100%;">
          <ul id="image-list" class="image-list news-slide-menu">
          <!-- <div class="item"> -->
          <?php $__currentLoopData = $section->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

              <?php
              // print_r($img->cover_image); die;
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($img->cover_image){
                $cover_image=$img->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }

              ?>
                <!-- <li id="image_<?php echo e($img->id); ?>" ><img src="<?php echo e($cover_image); ?>" class="rounded mh-100 h-100"></li> -->
                <!-- <div class="border border-white rounded mh-100 overflow-hidden h-105"> -->
         <li id="image_<?php echo e($img->id); ?>" >
         <div class="border border-white rounded mh-100 overflow-hidden h-105">
          <img src="<?php echo e($cover_image); ?>" class="rounded mh-100 h-100">
        </div>
        <div class="edit-icon">
          <!-- <a href="" data-toggle="modal" data-target="#exampleModal-<?php echo e($img->id); ?>"><i class="fa fa-edit text-primary pr-2"></i></a> -->
          <a href="" data-toggle="modal" data-target="#exampleModal-<?php echo e($img->id); ?>"><i class="material-icons" style="color:white;font-size:18px;">edit</i></a>
          <a href=""  data-toggle="modal" data-target="#deleteModal-<?php echo e($img->id); ?>"><i class="material-icons" style="color:white;font-size:18px;">delete</i></a>
        </div>
        <div class="py-2 pl-1">
          <p class="mb-0"><?php echo e($img->title); ?></p>
        </div>
       </li>

       <!-- Edit Content Modal -->
       <div class="modal fade" id="exampleModal-<?php echo e($img->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title text-uppercase" style="font-weight: 700;" id="exampleModalLabel">Edit content</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <form action="<?php echo e(url('dashboard/gallery/edit-content')); ?>" method="post" enctype="multipart/form-data">
                 <?php echo e(csrf_field()); ?>

                 <div class="form-group">
                   <input type="text" name="" class="select-img" id="file_name" placeholder="Insert a cover image">
                   <label for="insert-cover">
                     <button class="btn btn-default image-btn">Insert</button>
                   <input type="file" name="cover_image" id="insert-cover" onchange="document.getElementById('file_name').value = this.value.split('\\').pop().split('/').pop()">
                   </label>
                 </div>
                 <input type="hidden" name="content_id" value="<?php echo e($img->id); ?>">
                 <div class="form-group">
                   <div class="row">
                     <div class="col-md-8">
                       <input type="text" name="title" class="form-control" placeholder="title" value="<?php echo e($img->title); ?>">
                     </div>
                     <div class="col-md-3">
                       <input type="submit" name="edit_form" value="Save" class="btn btn-primary background-blue mt-0 mb-0 rounded">
                     </div>
                   </div>
                 </div>
                 <div class="form-group">

                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
       <!-- Edit Content Modal End -->
       <!-- Delete Content Modal -->
       <div class="modal fade" id="deleteModal-<?php echo e($img->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title text-uppercase" style="font-weight: 700;" id="exampleModalLabel">Delete Content ?</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
               <p>Are you sure want to delete this content "<?php echo e($img->title); ?>"?</p>
                 <input type="hidden" name="content_id" value="<?php echo e($img->id); ?>">
                 <div class="form-group">
                   <div class="row justify-content-center">
                     <div class="col col-md-3">
                       <a href="<?php echo e(url('/dashboard/gallery/delete-content/'.$img->id)); ?>" class="btn background-blue mt-0 mb-0 rounded w-100">Yes</a>
                     </div>
                     <div class="col col-md-3 pl-1">
                       <button type="button" class="btn background-pink mt-0 mb-0 rounded w-100" data-dismiss="modal">No</button>
                     </div>
                   </div>
                 </div>
             </div>
           </div>
         </div>
       </div>
       <!-- Delete Content Modal End -->

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    </div>
    </div>
    </div>
    </div>
  </div>
  </div>
  <div class="col-md-2">
    <div class="action" style="display:inline-grid;">
      <a href="" style="padding-right: 3px;" data-toggle="modal" data-target="#EditSectionModal-<?php echo e($section->id); ?>"><i class="material-icons" style="color:gray">edit</i></a>
      <a href="" data-toggle="modal" data-target="#duplicate_section-<?php echo e($section->id); ?>"><i class="material-icons" style="color:gray">library_add</i></a>
      <a href="" data-toggle="modal" data-target="#deleteSectoinModal-<?php echo e($section->id); ?>" style="padding-right: 3px;"> <i class="material-icons" style="color:gray">delete</i> </a>
    </div>
  </div>
</div>

<!-- Duplicate Section Modal -->
<div class="modal fade" id="duplicate_section-<?php echo e($section->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" style="font-weight:700;" id="exampleModalLabel">Duplicate Section <br>
        </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <div class="modal-body">
        <p style="font-size: 13px;text-transform: initial;">Create a new section from an old one, duplicating also all the content within it. </p>
        <form method="post" action="<?php echo e(url('/dashboard/gallery/duplicate-section')); ?>">
          <?php echo e(csrf_field()); ?>

          <div class="form-group">
            <div class="row">
              <div class="col-md-9">
                <input type="text" name="section_title" class="form-control" placeholder="Section title" required>
              </div>
              <input type="hidden" name="section_id" value="<?php echo e($section->id); ?>">
              <div class="col-md-3">
                <input type="submit" name="edit_form" value="Create" class="btn btn-primary background-blue mt-0 mb-0 rounded">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-8">
                <select class="c-select form-control" name="type" required>
                  <option selected disabled hidden="">Teams/Role</option>
                  <option disabled value="" style="font-weight: 700;">Teams</option>
                  <?php $__currentLoopData = Feed::teams(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="team,<?php echo e($team->id); ?>"><?php echo e($team->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <option disabled value="" style="font-weight: 700;">Roles</option>
                  <?php $__currentLoopData = Feed::roles(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="role,<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Duplicate Section Modal End -->
<!-- Edit Section Modal -->
<div class="modal fade" id="EditSectionModal-<?php echo e($section->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" style="font-weight: 700;" id="exampleModalLabel">Edit Section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo e(url('dashboard/gallery/edit-section')); ?>" method="post" enctype="multipart/form-data">
          <?php echo e(csrf_field()); ?>

          <div class="form-group">
            <div class="row">
              <div class="col-md-9">
                <input type="text" name="section_title" class="form-control" value="<?php echo e($section->title); ?>" placeholder="Section title" required>
              </div>
              <input type="hidden" name="section_id" value="<?php echo e($section->id); ?>">
              <div class="col-md-3">
                <input type="submit" name="edit_form" value="Update" class="btn btn-primary background-blue mt-0 mb-0 rounded">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-8">
                <select class="c-select form-control" name="type" required>
                  <!-- <option selected disabled hidden="">Teams/Role</option> -->
                  <option disabled value="" style="font-weight: 700;">Teams</option>
                  <?php $__currentLoopData = Feed::teams(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $type ='';
                  if('team,'.$team->id === $section->type.','.$section->team_role_id){
                    $type = 'yes';
                  }else{
                    $type = 'no';
                  }

                   ?>

                  <option value="team,<?php echo e($team->id); ?>" <?php echo e($type == 'yes' ? 'selected="selected"' : ''); ?>><?php echo e($team->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <option disabled value="" style="font-weight: 700;">Roles</option>
                  <?php $__currentLoopData = Feed::roles(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php
                  $type2 ='';
                  if('role,'.$role->id === $section->type.','.$section->team_role_id){
                    $type2 = 'yes';
                  }else{
                    $type2 = 'no';
                  }

                   ?>
                  <option value="role,<?php echo e($role->id); ?>" <?php echo e($type2 == 'yes' ? 'selected="selected"' : ''); ?>><?php echo e($role->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Section Modal End -->
<!-- Delete Section Modal -->
<div class="modal fade" id="deleteSectoinModal-<?php echo e($section->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-uppercase" style="font-weight: 700;" id="exampleModalLabel">Delete Content ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure want to delete this content "<?php echo e($section->title); ?>". Section and all contents on it ?</p>
          <input type="hidden" name="content_id" value="<?php echo e($section->id); ?>">
          <div class="form-group">
            <div class="row justify-content-center">
              <div class="col col-md-3">
                <a href="<?php echo e(url('/dashboard/gallery/delete-section/'.$section->id)); ?>" class="btn background-blue mt-0 mb-0 rounded w-100">Yes</a>
              </div>
              <div class="col col-md-3 pl-1">
                <button type="button" class="btn background-pink mt-0 mb-0 rounded w-100" data-dismiss="modal">No</button>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Delete Section Modal End -->
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script>
$(document).ready(function () {
    var dropIndex;
    $(".image-list").sortable({
          update: function(event, ui) {
            dropIndex = ui.item.index();
           changePosition();
        }
    });

    function changePosition() {
    // $('#submit').click(function (e) {
        var imageIdsArray = [];
        $('.image-list li').each(function (index) {
            // if(index <= dropIndex) {
                var id = $(this).attr('id');
                var split_id = id.split("_");
                imageIdsArray.push(split_id[1]);
            // }
        });

        $.ajax({
            url: "<?php echo e(url('/dashboard/gallery/reorderUpdate')); ?>",
            type: 'post',
            data: {imageIds: imageIdsArray,_token:"<?php echo e(csrf_token()); ?>"},
            success: function (response) {
              toastr.success('Order Updated successfully', '', {timeOut: 5000, positionClass: "toast-top-right"});
               // $("#txtresponse").css('display', 'inline-block');
               // $("#txtresponse").text(response);
            }
        });
        // e.preventDefault();
    // });
  }

});
</script>
