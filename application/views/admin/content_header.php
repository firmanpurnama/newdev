<div class="row">
   <div class="col-lg-12">
       <h1 class="page-header"><?=$this->content_header;?></h1>
		<ol class="breadcrumb breadcrumb-text">
			<!-- <li class="breadcrumb-item">
				<a href="index.html">Home</a>
			</li>
			<li class="breadcrumb-item active">About</li> -->
			<?php
			foreach ($this->breadcrumb as $b => $bc) {
				if ($b == (count($this->breadcrumb)-1)) {
					?>
					<li class="breadcrumb-item active">
						<?=$bc['title'];?>
					</li>
					<?php
				}else{
					?>
					<li class="breadcrumb-item">
						<a href="<?=base_url($bc['url']);?>"><?=$bc['title'];?></a>
					</li>
					<?php
				}
			}
			?>
		</ol>
   </div>
</div>