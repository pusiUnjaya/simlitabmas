<style>
.stepwizard { 
    margin-top:40px; 
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
<?php 	
	if($this->session->userdata('sesi_status')==1)
	{
		header('location:'.base_url().'dashboard');
	}
?>
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Kuesioner</h1>
</div>

<?php
	if($this->session->flashdata('result')<>'')
	{
		echo '<div class="alert alert-danger" role="alert">'.
			$this->session->flashdata('result').'
			</div>';
	}
?>

<!-- Content Row -->

<div class="row">

<div class="col-xl-12 col-lg-5">
  <!-- Basic Card Example -->
  <div class="card shadow mb-4">
	<div class="card-header py-3">
	  <h6 class="m-0 font-weight-bold text-primary">Silakan Isi Kuesioner Berikut</h6>
	</div>
	<div class="card-body">
	<div class="stepwizard">
		<div class="stepwizard-row setup-panel">
			<div class="stepwizard-step">
				<a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
				<p>LPPM</p>
			</div>
			<!-- <div class="stepwizard-step">
				<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
				<p>PPPM</p>
			</div> -->
		</div>
	</div>
	<form role="form" method="post" action="<?php echo base_url(); ?>kuesioner/simpan" enctype="multipart/form-data">
		<div class="row setup-content" id="step-1">
			<div class="col-xl-12" style="margin-top:30px">
				<div class="row">
				<input type="hidden" name="dosen" value="<?php echo $this->session->userdata('sesi_id'); ?>">
				<input type="hidden" name="ques" value="lppm">
				<div class="col-md-6">
					<p><b>1. Layanan administrasi penelitian/PkM</b>
					<div class="form-check form-check-inline">
						<label class="radio-inline">
						  <input class="form-check-input" type="radio" name="ans1" id="inlineCheckbox1" value="1" required> Kurang Puas
						</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans1" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans1" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans1" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>2. Staf LPPM/PPPM memberi tanggapan yang cepat dan baik terhadap kebutuhan saudara</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans2" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans2" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans2" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans2" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>3. Petugas LPPM/PPPM bersikap sopan dan ramah</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans3" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans3" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans3" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans3" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>4. Kepastian jadwal penelitian/PkM</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans4" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans4" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans4" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans4" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>5. Ketersediaan panduan penelitian/PkM di Unjaya</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans5" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans5" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans5" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans5" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>6. Kejelasan penilaian proposal penelitian/PkM</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans6" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans6" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans6" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans6" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>7. Ketersediaan SOP pelayanan LPPM Unjaya</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans7" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans7" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans7" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans7" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>8. Kemudahan penerimaan dana penelitian/PkM</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans8" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans8" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans8" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans8" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>9. Pengelolaan hibah internal Unjaya</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans9" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans9" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans9" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans9" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
				</div>
				<div class="col-md-6">
					<p><b>10. Pengelolaan hibah eksternal Unjaya.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans10" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans10" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans10" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans10" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>11. Kecukupan dana penelitian/PkM internal.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans11" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans11" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans11" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans11" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>12. Ketersediaan jurnal internal terakreditasi di Unjaya.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans12" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans12" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans12" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans12" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>13. Sistem informasi (Simlitabmas) penelitian dan PkM.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans13" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans13" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans13" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans13" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>14. Ketersediaan sarana dan prasarana penelitian dan PkM.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans14" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans14" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans14" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans14" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>15. Website lembaga pengabdian masyarakat.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans15" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans15" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans15" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans15" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<p><b>16. Pemberian informasi penerimaan hibah penelitian dan PKM eksternal.</b>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans16" id="inlineCheckbox1" value="1" required>
					   Kurang Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans16" id="inlineCheckbox2" value="2" required>
					   Cukup Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans16" id="inlineCheckbox1" value="3" required>
					   Puas</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="radio-inline"><input class="form-check-input" type="radio" name="ans16" id="inlineCheckbox2" value="4" required>
					   Sangat Puas</label>
					</div>
					</p>
					<label><b>Saran/Masukan</b></label>
					<textarea name="saran" rows="5" class="form-control" placeholder="Saran/Masukan"></textarea>
					</p>
					<button class="btn btn-success finish btn-lg pull-right" type="submit">Simpan!</button>
				</div>
				</div>
			</div>
		</div>
	</form>
	</div>
  </div>
</div>
</div>

<script>
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');
            finish = $('.finish');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("textarea,input[type='text'],input[type='radio'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });
	
	finish.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>