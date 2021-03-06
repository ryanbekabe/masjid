<?php 
    session_start();  
    if(!isset($_SESSION['user_login'])){
      header('Location: ../login.php' );
      die();
    } else{
      require_once('../../controller/AuthController.php');
      $auth = new AuthController();
      $user_login = $auth->getUserLogin();
    }
    
    require_once('../template/header.php');
    require_once('../template/navbar.php');
    require_once('../../controller/kegiatanController.php');
    $kegiatan  = new kegiatanController();
    $id_kegiatan = $_GET['id_kegiatan'];
    $kegiatan  = $kegiatan->getById($id_kegiatan);
?>

<!-- Content -->
<div class="px-content">
    <ol class="breadcrumb page-breadcrumb">
        <li><a href="javascript:void(0)">Kelola Kegiatan</a></li>
        <li class="active">Edit Kegiatan</li>
    </ol>

    <div class="page-header">
      <h1><i class="px-nav-icon ion-ios-paper"></i><span class="px-nav-label"></span>KELOLA KEGIATAN</h1>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Edit Kegiatan</span>
                    <div class="panel-heading-controls">
                      <button class="btn btn-default btn-xs" id="btn-minimize"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-default btn-xs" id="btn-show" style="display:none;"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="panel-body"  id="box-kegiatan">

                    <?php if(isset($_SESSION['form']) && $_SESSION['form'] == 1){ ?>
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                Pastikan data pada form telah terisi dengan benar!
                            </div>
                        </div>
                        <br><br>
                    <?php 
                            unset($_SESSION['form']);
                        }
                    ?>
                    <form action="kegiatan_proses.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <?php 
                        if(isset($kegiatan)){
                            while($row = $kegiatan->fetch()){
                        ?>
                        <input type="hidden" name="id" value="<?php echo $row['id_kegiatan']; ?>">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">Nama Kegiatan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="nama_kegiatan" value="<?php echo $row['nama_kegiatan'];?>" placeholder="Masukan nama kegiatan..." class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">Waktu Pelaksanaan</label>
                                <div class="col-sm-6">
                                    <input id="event_date" type="text" name="event_date" value="<?php echo date('m/d/Y',strtotime($row['event_date']));?>" placeholder="Masukan waktunya ..." class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">Foto</label>
                                <div class="col-sm-6">
                                    <img id="img-gambar" src="../../uploads/kegiatan/<?php echo $row['gambar'];?>" alt="Foto" style="width:200px;">
                                    <input type="file" id="gambar" name="gambar" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">Deskripsi</label>
                                <div class="col-sm-10">
                                <textarea id="summernote-base" name="deskripsi"><?php echo $row['deskripsi'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" id="btnEdit" name="submit-update" class="btn btn-primary"><i class="fa fa-edit"></i> Update</button>
                                </div>
                            </div>
                        </div>
                        <?php }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  // Initialize Summernote
    $(function() {
      $('#summernote-base').summernote({
          height: 200,
          toolbar: [
          ['parastyle', ['style']],
          ['fontstyle', ['fontname', 'fontsize']],
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['insert', ['picture', 'link', 'video', 'table', 'hr']],
          ['history', ['undo', 'redo']],
          ['misc', ['codeview', 'fullscreen']],
          ['help', ['help']]
          ],
      });
    });

    $(function(){
      $("#btn-minimize").click(function(){
        $("#box-kegiatan").fadeOut();
        $("#btn-minimize").hide();
        $("#btn-show").show();
      });

      $("#btn-show").click(function(){
        $("#box-kegiatan").fadeIn();
        $("#btn-minimize").show();
        $("#btn-show").hide();
      });
    });

    $(function(){
        $("#menu-kegiatan").addClass('active');
        $("#event_date").datepicker();
    });
</script>

<?php 
    require_once('../template/footer.php');
?>