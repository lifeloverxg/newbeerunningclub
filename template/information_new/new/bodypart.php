<div class ="content">
	<div class ="main">
		<div class="direction">
			<span><a href="<?php echo $home ?>">首页</a></span>
			<span><a href="<?php echo $home.'information' ?>">综合</a></span>
			<span>新生</span>
			<hr style="border:1px dotted rgb(210,210,210); margin-top: 10px;" />
		</div> 

		<h5 style="margin-bottom:20px;letter-spacing:5px"> 请选择您的学校...</h5>
		
		<div class="schools">
			<ul class="ul-school-list">
<?php foreach($school_list as $school_key => $school_value) { ?>
				<li>
					<!-- <div class="school-logo" >
						<a href="<?php echo $home.$school_value['url']; ?>">
							<img src="<?php echo $home.$school_value['image']?>">
							<p id="heiti"><?php echo $school_value['title']?> </p>
						</a>
					</div> -->
					<div class="div-logo-school">
						<a href="<?php echo $home.$school_value['url']; ?>" class="card-photo nametag-photo" style="background-image: url(<?php echo $home.$school_value['image']; ?>); background-size: <?php if ($deviceType == "phone") {echo "300px 200px";} else {echo "200px 133px";}?>">
							<div class="nametag-photo-name">
									<?php echo $school_value['title']; ?>
							</div>
						</a>
					</div>
				</li>
<?php } ?>
			</ul>
		</div>
	</div>
</div>
<h6 style="margin-top: 200px; letter-spacing:2px"> 如果您没有找到您的学校, 可以在此创建群组</h6>

<style type="text/css">

.schools
{
	margin: auto;
	text-align: center;
	float: left;
}

.ul-school-list>li
{
    width: 200px;
    float: left;
    background: rgba(255, 255, 255, 0.3);
    margin: 0px 16px 24px 0;
    position: relative;
    color: black;
    overflow: hidden;
    display: block;
}

.nametag-photo
{
	height: 133px;
}

.school-logo>a>img
{
	width: 200px;
}
.school-logo>a>p
{
	font-size:18px;
	margin:5px auto;
	color: black;
	width: 200px;
}
a
{
	text-decoration: none;
}

@media (max-width: 767px)
{
	.ul-school-list>li
	{
	    width: 300px;
	}
	.school-logo>a>img
	{
		width: 300px;
	}
	.school-logo>a>p
	{
		width: 300px;
	}
	.nametag-photo
	{
		height: 200px;
	}
}



</style>

