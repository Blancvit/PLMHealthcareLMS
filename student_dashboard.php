<?php
include('session.php');
include('header.php');
?>

<body>
	<?php include('navbar_student.php'); ?>
	<!-- Breadcrumb -->
	<div class="container-fluid my-4 justify-content-center pb-5">
		<div class="container mx-auto">
			<div class="container py-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb bg-body rounded-3 p-3">
						<?php
						$school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error($conn));
						$school_year_query_row = mysqli_fetch_array($school_year_query);
						$school_year = $school_year_query_row['school_year'];
						?>
						<li class="breadcrumb-item">
							<a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>

						</li>
						<li class="breadcrumb-item active">
							My Class
						</li>
					</ol>
				</nav>
			</div>

			<div class="container mb-3">
				<div class="container bg-body rounded-3 justify-content-center align-items-center p-0" style="overflow-y: auto; height: 600px; max-height: 600px;">
					<div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
						<div class="col text-uppercase pt-1 px-2">
							<h4 style="font-weight: 800; color: #fff;"><i class="bi bi-person-workspace me-2"></i> Dashboard</h4>
						</div>
					</div>
					<div class="container d-flex mb-3 p-2 rounded-top-3">
						<form action="read_message.php" method="post">
							<div class="container mt-3 mb-3 bg-body-tertiary p-3 rounded-3 mx-2" style="width: 350px; max-width: 350px; height: 450px; max-height: 100vh; overflow-y:auto;"> <!-- Add a container with margin-top -->
								<h4 class="bg-body px-2 py-2 rounded-3" style="font-weight: 800; color: #fff;">LATEST</h4>
								<hr>
								<div class="p-0">
									<?php
									$query_latest = mysqli_query($conn, "SELECT * FROM teacher_class_student
									LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id 
									LEFT JOIN class ON class.class_id = teacher_class.class_id 
									LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
									LEFT JOIN teacher ON teacher.teacher_id = teacher_class_student.teacher_id
									LEFT JOIN notification ON notification.teacher_class_id = teacher_class.teacher_class_id 
									JOIN class_quiz ON class_quiz.teacher_class_id = notification.teacher_class_id
									WHERE teacher_class_student.student_id = '$session_id' AND school_year = '$school_year'  order by notification.date_of_notification DESC") or die(mysqli_error($conn));
									$count_latest = mysqli_num_rows($query_latest);
									$limit = 0;
									if ($count_latest > 0) {
										while ($row_latest = mysqli_fetch_array($query_latest)) {
											$get_id = $row_latest['teacher_class_id'];
											$get_area = $row_latest['area'];
											$id = $row_latest['notification_id'];

											$query_yes_read = mysqli_query($conn, "SELECT * FROM notification_read where notification_id = '$id' and student_id = '$session_id'") or die(mysqli_error($conn));
											$read_row = mysqli_fetch_array($query_yes_read);
											$yes = $read_row['student_read'] ?? '';
											if ($limit < 3) {
									?>
												<div class="container mt-3"> <!-- Add a container with margin-top -->
													<div class="border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
														<div class="d-flex justify-content-between align-items-center">
															<div class="message-content">
																<strong><?php echo $row_latest['firstname'] . " " . $row_latest['lastname']; ?></strong>
																<?php echo $row_latest['notification']; ?>
																<strong><a href="<?php echo $row_latest['link']; ?><?php echo '?id=' . $get_id; ?><?php echo '&area=' . $get_area; ?>">
																		<?php echo $row_latest['class_name']; ?>
																		<?php echo $row_latest['subject_code']; ?>
																	</a></strong>
															</div>
														</div>
														<hr>
														<div class="justify-content-between align-items-center">
															<div class="text-muted">
																<i class="bi bi-calendar3"></i> <?php echo $row_latest['date_of_notification']; ?>
															</div>
														</div>
													</div>
												</div>

										<?php }
											$limit = $limit + 1;
										}
									} else { ?>
										<div class="alert alert-info p-2 mt-3"><i class="bi bi-info-circle"></i> No Notifications</div>
									<?php } ?>
								</div>
							</div>
						</form>
						<div class="container bg-body-tertiary rounded-3 mb-3 mt-3 p-3 ms-2 me-1" style="overflow-y: auto; height: 450px; max-height: 100vh;">
							<?php
							$query_quiz = mysqli_query($conn, "SELECT * FROM class_quiz 
            LEFT JOIN quiz ON class_quiz.quiz_id = quiz.quiz_id
            LEFT JOIN teacher_class ON class_quiz.teacher_class_id = teacher_class.teacher_class_id 
            LEFT JOIN class ON teacher_class.class_id = class.class_id
            JOIN subject ON teacher_class.subject_id = subject.subject_id
            LEFT JOIN student_class_quiz ON class_quiz.class_quiz_id = student_class_quiz.class_quiz_id
            WHERE student_class_quiz.grade IS NULL
            ORDER BY class_quiz.class_quiz_id DESC") or die(mysqli_error($conn));
							$count_quiz = mysqli_num_rows($query_quiz);
							?>
							<div class="d-flex bg-body rounded-3 px-2 py-2 ">
								<div class="col text-uppercase pt-1 px-2">
									<h4 style="font-weight: 800; color: #fff;"><i class="bi bi-file-text-fill me-2"></i> Pending simulations / quizzes</h4>
								</div>
								<span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count_quiz; ?></span>
							</div>
							<hr>
							<div class="container justify-content-sm-center">
								<div class="row justify-content-center">
									<?php
									if ($count_quiz == '0') { ?>
										<div class="container p-4" id="alertSim">
											<div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> Great work! No pending Simulations / Quiz right now.</div>
										</div>
									<?php

									} else {
									?>
										<div class="table-responsive-lg">
											<table class="table table-striped p-3 text-center" id="simTable">
												<thead>
													<tr class="text-uppercase">
														<th>Title</th>
														<th>class</th>
														<th>subject</th>
														<th>area</th>
														<th>progress</th>
													</tr>
												</thead>
												<tbody class="table-group-divider">
													<?php
													while ($row_quiz = mysqli_fetch_array($query_quiz)) {
														$id = $row_quiz['class_quiz_id'];
														$quiz_id = $row_quiz['quiz_id'];
														$quiz_time = $row_quiz['quiz_time'];

														$query1 = mysqli_query($conn, "SELECT * FROM student_class_quiz WHERE class_quiz_id = '$id' AND student_id = '$session_id'") or die(mysqli_error($conn));
														$row1 = mysqli_fetch_array($query1);
														$grade = $row1['grade'] ?? '';
														if ($grade == "") { // Check if grade is empty
													?>
															<tr>
																<td><?php echo $row_quiz['quiz_title']; ?></td>
																<td><b><?php echo $row_quiz['class_name']; ?></b></td>
																<td><b><?php echo $row_quiz['subject_code']; ?></b></td>
																<td>
																	<?php echo $row_quiz['area']; ?>
																</td>
																<td>
																	<span class="badge bg-secondary">NOT YET TAKEN</span>
																</td>
															</tr>
													<?php }
													} ?>
												</tbody>
											</table>
										</div>
									<?php } ?>
								</div>
							</div>

							<?php
							// Assuming you have already established a database connection $conn
							$query_retdem = mysqli_query($conn, "SELECT * FROM assignment 
							LEFT JOIN teacher_class ON assignment.class_id = teacher_class.teacher_class_id 
							LEFT JOIN class ON teacher_class.class_id = class.class_id
							JOIN subject ON teacher_class.subject_id = subject.subject_id
							WHERE assignment.assignment_id NOT IN (SELECT assignment_id FROM student_assignment WHERE grade IS NOT NULL)
							ORDER BY fdatein DESC") or die(mysqli_error($conn));
							$count_retdem = mysqli_num_rows($query_retdem);
							?>
							<div class="d-flex bg-body rounded-3 px-2 py-2 ">
								<div class="col text-uppercase pt-1 px-2">
									<h4 style="font-weight: 800; color: #fff;"><i class="bi bi-file-text-fill me-2"></i> Pending retdems</h4>
								</div>
								<span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count_retdem; ?></span>
							</div>
							<hr>
							<div class="container justify-content-sm-center">
								<div class="row justify-content-center">
									<?php
									if ($count_retdem == '0') { ?>
										<div class="container p-4" id="alertSim">
											<div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> Great work! No pending RETDEMs right now.</div>
										</div>
									<?php
									} else {
									?>
										<div class="table-responsive-lg">
											<table class="table table-striped align-middle p-3 text-center justify-content-center" id="">
												<thead>
													<tr class="text-uppercase">
														<th>File Name</th>
														<th>Class</th>
														<th>Subject</th>
														<th>Deadline</th>
													</tr>

												</thead>
												<tbody class="table-group-divider">
													<?php
													while ($row_retdem = mysqli_fetch_array($query_retdem)) {
														$id  = $row_retdem['assignment_id'];
														$floc = $row_retdem['floc'];
														$query2 = mysqli_query($conn, "SELECT * FROM student_assignment 
													LEFT JOIN student ON student.student_id  = student_assignment.student_id
													WHERE assignment_id = '$id'  ORDER BY assignment_fdatein DESC") or die(mysqli_error($conn));
														$row2 = mysqli_num_rows($query2);
														$row2fetch = mysqli_fetch_array($query2);
													?>
														<?php
														if ($row2 > 0) {
															if ($row2fetch['grade'] != null) {
															}
														} else { ?>
															<tr>
																<td><?php echo $row_retdem['fname']; ?></td>
																<td><b><?php echo $row_retdem['class_name']; ?></b></td>
																<td><b><?php echo $row_retdem['subject_code']; ?></b></td>
																<td><?php echo $row_retdem['deadline']; ?></td>
															</tr>
													<?php
														}
													} ?>
												</tbody>
											</table>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="container">
				<div class="container bg-body rounded-3 justify-content-center align-items-center p-0" style="overflow-y: auto; height: 550px; max-height: 550px;">
					<div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
						<div class="col text-uppercase pt-1 px-2">
							<h4 style="font-weight: 800; color: #fff;"><i class="bi bi-person-workspace me-2"></i> my subjects</h4>
						</div>
						<?php
						$query = mysqli_query($conn, "SELECT * FROM teacher_class_student
                                            LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id 
                                            LEFT JOIN class ON class.class_id = teacher_class.class_id 
                                            LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                            LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
                                            WHERE student_id = '$session_id' and school_year = '$school_year'
                                            ORDER BY class_name ASC") or die(mysqli_error($conn));
						$count = mysqli_num_rows($query);
						?>
						<span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
					</div>

					<div class="container-fluid row row-cols-5 justify-content-sm-center">
						<?php
						if ($count != '0') {
							while ($row = mysqli_fetch_array($query)) {
								$id = $row['teacher_class_id'];
						?>
								<div class="col-sm-auto class-box justify-content-center text-center my-4" id="del<?php echo $id; ?>">
									<div class="card card-1 mx-auto mb-2 p-4" style="background-image: url('<?php echo $row['thumbnails'] ?>'); background-size: cover; width: 150px; height: 150px;">
										<a href="student_map.php<?php echo '?id=' . $id; ?>">
											<div class="card-img-overlay d-flex flex-column justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
												<h3><?php echo $row['subject_code']; ?></h3>
												<p class="mb-0 mt-2"><?php echo $row['class_name']; ?></p>
											</div>
										</a>
									</div>
								</div>
							<?php }
						} else { ?>
							<div class="alert alert-info"><i class="bi bi-info-circle"></i> You are currently not enrolled in any class.</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include('scripts.php'); ?>
</body>