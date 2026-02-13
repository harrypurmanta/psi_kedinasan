<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Soal</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/custom.css">
  <link rel="stylesheet" href="<?= base_url() ?>/dist/css/sweetalert2.css">
  <style>
    #loader-wrapper {
	display: flex;
	position: fixed;
	z-index: 1060;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	flex-direction: row;
	align-items: center;
	justify-content: center;
	padding: 0.625em;
	overflow-x: hidden;
	transition: background-color 0.1s;
	background-color: rgb(253 253 253 / 58%);
	-webkit-overflow-scrolling: touch;
}

.loader {
	border: 10px solid #f3f3f3;
	border-radius: 50%;
	border-top: 10px solid #3af3f5;
	border-bottom: 10px solid #3abcec;
	width: 50px;
	height: 50px;
	-webkit-animation: spin 2s linear infinite;
	animation: spin 2s linear infinite;
	margin: 1.75rem auto;
}

	

		@keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-moz-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-webkit-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-o-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-ms-keyframes fadeIn {
		  0% {
		    opacity: 0;
		  }
		  100% {
		    opacity: 1;
		  }
		}

		@-webkit-keyframes spin {
		  0% {
		    -webkit-transform: rotate(0deg);
		  }
		  100% {
		    -webkit-transform: rotate(360deg);
		  }
		}

		@keyframes spin {
		  0% {
		    transform: rotate(0deg);
		  }
		  100% {
		    transform: rotate(360deg);
		  }
		}
  </style>
</head>