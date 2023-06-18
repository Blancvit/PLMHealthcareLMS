<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
	<?php include('navbar_student_areas.php'); ?>
	<!-- Navbar -->
	<div class="container-fluid my-4 justify-content-center pb-5">
		<div class="container mx-auto justify-content-center">
			<div class="container py-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb bg-body rounded-3 p-3">
						<?php $class_query = mysqli_query($conn, "select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_class_id = '$get_id'") or die(mysqli_error($conn));
						$class_row = mysqli_fetch_array($class_query);
						?>
						<li class="breadcrumb-item">
							<a class="link-body-emphasis fw-semibold text-decoration-none">School Year: <?php echo $class_row['school_year']; ?></a>

						</li>
						<li class="breadcrumb-item">
							<a class="link-body-emphasis fw-semibold text-decoration-none"> <?php echo $class_row['class_name']; ?></a>
						</li>
						<li class="breadcrumb-item">
							<a class="link-body-emphasis fw-semibold text-decoration-none"> <?php echo $class_row['subject_code']; ?></a>
						</li>
						<li class="breadcrumb-item active">
							Areas
						</li>
					</ol>
				</nav>
			</div>


			<div class="container border-black rounded-3 p-0 mb-4 me-3">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1200 500" style="enable-background:new 0 0 1200 500;" xml:space="preserve" width="100%" height="100%" preserveAspectRatio="">
					<style type="text/css">
						text {
							fill: #FFFFFF;
							font-family: 'Verdana';
							font-size: 18px;
							pointer-events: none;
							transition: color .2s ease-in-out;
						}

						.st1 {
							fill: none;
							stroke: #FFFFFF;
							stroke-miterlimit: 10;
						}

						.st2 {
							fill: none;
							stroke: #FFFFFF;
							stroke-width: 5;
							stroke-miterlimit: 10;
						}

						.notused polygon,
						.notused rect,
						.notused path {
							fill: #ffffff;
							fill-opacity: 0;
							stroke: #FFFFFF;
							stroke-miterlimit: 10;
						}

						.area polygon,
						.area rect,
						.area path {
							fill: #ffffff;
							fill-opacity: 0;
							stroke: #FFFFFF;
							stroke-miterlimit: 10;
							cursor: pointer;
							transition: all .2s ease-in-out;
						}

						.area:hover polygon,
						.area:hover rect,
						.area:hover path {
							fill-opacity: 1;
						}

						.area:focus polygon,
						.area:focus rect,
						.area:focus path {
							fill-opacity: 1;
						}

						.area:hover text {
							fill: #000000;
						}

						.area:focus text {
							fill: #000000;
						}

						a {
							text-decoration: none;
						}
					</style>

					<g id="outlines">
						<polyline class="st2" points="939.3,208.1 921.4,226.1 1035.8,340.5 1056.9,319.4 1105.9,270.4 1135.9,240.4 1053.2,157.7 1023.1,187.7 991.4,156 950.4,197.1"></polyline>
						<polyline class="st2" points="273.8,254.9 273.8,218.2 123.9,218.2 123.9,411.6 273.8,411.6 273.8,269.8"></polyline>
						<polygon class="st1" points="935.6,183.2 739.2,183.2 653.8,183.2 651.3,183.2 651.3,254.4 497.4,254.4 497.4,179.7 479.5,179.7 479.5,254.4 262.2,254.4 199,254.4 199,270.3 234.2,270.3 251.6,270.3 510.7,270.3 510.7,346 528.2,346 528.1,270.8 666,270.8 666,255.6 739.2,255.6 739.2,199.1 789.1,199.1 789.1,213.7 854.7,213.7 854.7,199.1 929.7,199.1 964,230.4 974.6,218.8 974.6,218.8"></polygon>
						<polyline class="st2" points="896.7,183.2 896.7,55.7 787.5,55.7 787.5,127.5 741.2,127.5 741.2,95.4 652.3,95.4 652.3,55.7 585.1,55.7 585.1,95.5 563.1,95.5 563.1,55.7 495.9,55.7 495.9,95.5 472,95.5 472,55.7 318.7,55.7 318.7,254.4"></polyline>
						<polyline class="st2" points="318.7,270.3 318.7,347.9 526,347.9 526.3,383.4 741.2,383.4 741.2,350 768.2,350 768.2,253.6 741.2,253.6 741.2,200.6 787.5,200.6 787.5,215.5 856.7,215.5 856.7,199.1"></polyline>
					</g>
					<g id="a2" class="notused" aria-role="button" aria-hidden="true" tabindex="-1">
						<polygon points="766.2,255.6 739.2,255.6 666,255.6 666,381 739.2,381.4 739.2,348 766.2,348 	"></polygon>
						<!--<text transform="matrix(1 0 0 1 685 315)">AREA 2</text>-->
					</g>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id; echo '&area=Emergency'  ?>">
						<g id="a4" class="area" aria-role="button" tabindex="0">
							<polygon points="253.6,270.3 236.2,270.3 199,270.3 199,254.4 264.2,254.4 271.5,254.4 271.5,220.5 126.1,220.5
						126.1,409.9 271.5,409.9 271.5,270.3"></polygon>
							<text transform="matrix(1 0 0 1 143 331)">EMERGENCY</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Pediatrics'  ?>">
						<g id="a5" class="area" aria-role="button" tabindex="0">
							<polygon points="470,97.5 470,57.7 320.7,57.7 320.8,254.2 479.5,254.4 479.5,179.7 497.4,179.7 497.9,97.5"></polygon>
							<text transform="matrix(1 0 0 1 349 174)">PEDIATRICS</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Gerontology'  ?>">
						<g id="a6" class="area" aria-role="button" tabindex="0">
							<polygon points="511,345.9 511,270.9 320.4,270.8 320.4,346.1 511,346.1 511,345.9"></polygon>
							<text transform="matrix(1 0 0 1 348 318)">GERONTOLOGY</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Medical-Surgical'  ?>">
						<g id="a7" class="area" aria-role="button" tabindex="0">
							<polygon points="587.1,57.7 587.1,97.5 561.1,97.5 561.1,57.7 497.9,57.7 497.4,254.4 560.6,254 587.6,254 651,254 650.3,57.7"></polygon>
							<text transform="matrix(1 0 0 1 526 162)">
								<tspan>MEDICAL -</tspan>
								<tspan dy="1em" dx="-5.3em">SURGICAL</tspan>
							</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Maternal and Child'  ?>">
						<g id="a3" class="area" aria-role="button" tabindex="0">
							<rect x="528.1" y="270.8" width="137.9" height="110.2"></rect>
							<text transform="matrix(1 0 0 1 550 325)">
								<tspan>MATERNAL</tspan>
								<tspan dy="1em" dx="-5.3em">&amp; CHILD</tspan>
							</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Faculty Resources'  ?>">
						<g id="a1" class="area" aria-role="button" tabindex="0">
							<polygon points="739.2,129.5 739.2,97.4 650.5,97.3 650.5,129.1 650.5,170.8 650.5,183 789.7,183 789.7,129.1 	"></polygon>
							<text transform="matrix(1 0 0 1 680 150)">
								<tspan>FACULTY</tspan>
								<tspan dy="1em" dx="-5.3em">RESOURCES</tspan>
							</text>
						</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Library'  ?>">
					<g id="a8" class="area" aria-role="button" tabindex="0">
						<rect x="789.6" y="57.4" width="105.1" height="125.7"></rect>
						<text transform="matrix(1 0 0 1 804 131)">LIBRARY</text>
					</g>
					</a>
					<a href="student_quiz_list.php<?php echo '?id=' . $get_id;echo '&area=Mental Health'  ?>">
						<g id="a9" class="area" aria-role="button" tabindex="0">
							<path d="M1053.2,159.7l-29,29L992.4,157c-13.6,13.6-27.2,27.2-40.8,40.8l23,21L964,230.4L940.5,209 c-0.1,0.1-0.1,0.1-0.2,0.2c-5.7,5.7-11.3,11.3-17,17l114.4,114.4l21.1-21.1l48-48l29-29L1053.2,159.7z"></path>
							<text transform="matrix(1 0 0 1 998 245)">
								<tspan>MENTAL</tspan>
								<tspan dy="1em" dx="-4.4em">HEALTH</tspan>
							</text>
						</g>
					</a>
				</svg>
			</div>
		</div>
	</div>

	<?php include('scripts.php'); ?>
</body>

</html>