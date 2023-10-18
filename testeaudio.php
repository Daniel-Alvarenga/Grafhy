<?php

include_once('config.php');

if(!isset($_SESSION['user'])){
    header('location: login.php');
}
else{
    $user_name = $_SESSION['user'];
}

if(isset($_POST['submit'])){

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="background-color: black;">

    <form action="" enctype="multipart/form-data">

    </form>    

	<audio id="audioPlayer" controls></audio>

	<script>
		const start = document.getElementById('start');
		const stopButton = document.getElementById('stopButton');
		const audioPlayer = document.getElementById('audioPlayer');

		let audioStream;
		let audioChunks = [];

		start.addEventListener('click', startRecording);
		stopButton.addEventListener('click', stopRecording);

		function startRecording() {
			navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
				audioStream = stream;
				const mediaRecorder = new MediaRecorder(stream);
				mediaRecorder.start();

				mediaRecorder.addEventListener('dataavailable', event => {
					audioChunks.push(event.data);
				});

				mediaRecorder.addEventListener('stop', () => {
					const audioBlob = new Blob(audioChunks);
					const audioUrl = URL.createObjectURL(audioBlob);
					audioPlayer.src = audioUrl;
				});
			})
		}

		function stopRecording() {
			audioStream.getTracks().forEach(track => {
				track.stop();
			});
		}
	</script>
</body>
</html>