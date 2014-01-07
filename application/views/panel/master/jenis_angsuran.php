<?php $this->load->view( 'panel/common/meta', array( 'title' => 'Jenis Angsuran' ) ); ?>

<body>
<?php $this->load->view( 'panel/common/header'); ?>

<div class="content">
	<?php $this->load->view( 'panel/common/sidebar'); ?>
	
  	<div class="mainbar">
	    <div class="page-head">
			<h2 class="pull-left button-back">Jenis Angsuran</h2>
			<div class="clearfix"></div>
		</div>
		
	    <div class="matter"><div class="container">
            <div class="row"><div class="col-md-12">
				
				<div class="widget grid-main">
					<div class="widget-head">
						<div class="pull-left">
							<button class="btn btn-info btn-xs btn-add-jenis-angsuran">Tambah</button>
						</div>
						<div class="widget-icons pull-right">
							<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
							<a href="#" class="wclose"><i class="fa fa-times"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="widget-content">
						<table id="datatable" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Control</th></tr>
							</thead>
							<tbody></tbody>
						</table>
						
						<div class="widget-foot">
							<br /><br />
							<div class="clearfix"></div> 
						</div>
					</div>
				</div>
				
				<div class="widget hide" id="form-jenis-angsuran">
					<div class="widget-head">
						<div class="pull-left">Form Jenis Angsuran</div>
						<div class="widget-icons pull-right">
							<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
							<a href="#" class="wclose"><i class="fa fa-times"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					
					<div class="widget-content">
						<div class="padd"><form class="form-horizontal">
							<input type="hidden" name="action" value="update" />
							<input type="hidden" name="id" value="0" />
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Name</label>
								<div class="col-lg-10">
									<input type="text" name="name" class="form-control" placeholder="Name" />
								</div>
							</div>
							<hr />
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-9">
									<button type="submit" class="btn btn-info">Save</button>
									<button type="button" class="btn btn-info btn-show-grid">Cancel</button>
								</div>
							</div>
						</form></div>
					</div>
				</div>  
				
			</div></div>
        </div></div>
    </div>
	<div class="clearfix"></div>
</div>

<?php $this->load->view( 'panel/common/footer' ); ?>
<?php $this->load->view( 'panel/common/library_js'); ?>

<script>
$(document).ready(function() {
	var dt = null;
	var page = {
		show_grid: function() {
			$('.grid-main').show();
			$('#form-jenis-angsuran').hide();
		},
		show_form_jenis_angsuran: function() {
			$('.grid-main').hide();
			$('#form-jenis-angsuran').show();
		}
	}
	
	// global
	$('.btn-show-grid').click(function() {
		page.show_grid();
	});
	
	// grid
	var param = {
		id: 'datatable',
		source: web.host + 'panel/master/jenis_angsuran/grid',
		column: [ { }, { bSortable: false, sClass: "center" } ],
		callback: function() {
			$('#datatable .btn-edit').click(function() {
				var raw_record = $(this).siblings('.hide').text();
				eval('var record = ' + raw_record);
				
				Func.ajax({ url: web.host + 'panel/master/jenis_angsuran/action', param: { action: 'get_by_id', id: record.id }, callback: function(result) {
					$('#form-jenis-angsuran [name="id"]').val(result.id);
					$('#form-jenis-angsuran [name="name"]').val(result.name);
					page.show_form_jenis_angsuran();
				} });
			});
			
			$('#datatable .btn-delete').click(function() {
				var raw_record = $(this).siblings('.hide').text();
				eval('var record = ' + raw_record);
				
				Func.confirm_delete({
					data: { action: 'delete', id: record.id },
					url: web.host + 'panel/master/jenis_angsuran/action', callback: function() { dt.reload(); }
				});
			});
		}
	}
	dt = Func.init_datatable(param);
	
	// form jenis angsuran
	$('.btn-add-jenis-angsuran').click(function() {
		page.show_form_jenis_angsuran();
		$('#form-jenis-angsuran form')[0].reset();
		$('#form-jenis-angsuran [name="id"]').val(0);
	});
	$('#form-jenis-angsuran form').validate({
		rules: {
			name: { required: true, minlength: 2 }
		}
	});
	$('#form-jenis-angsuran form').submit(function() {
		if (! $('#form-jenis-angsuran form').valid()) {
			return false;
		}
		
		var param = Site.Form.GetValue('form-jenis-angsuran');
		Func.ajax({ url: web.host + 'panel/master/jenis_angsuran/action', param: param, callback: function(result) {
			if (result.status == 1) {
				dt.reload();
				page.show_grid();
				$('#form-jenis-angsuran form')[0].reset();
			}
		} });
		
		return false;
	});
});
</script>
</body>
</html>