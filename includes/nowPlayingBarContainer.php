<?php 
  $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
  $resultArray = array();

  while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
  }

  $jsonArray = json_encode($resultArray);

?>

<script>
  $(document).ready(function() {
    var newPlayList = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlayList[0], newPlayList, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
      e.preventDefault();
    })

    $(".playbackBar .progressBar").mousedown(function() {
      mouseDown = true;
    });

    $(".playbackBar .progressBar").mousemove(function(e) {
      if (mouseDown) {
        //Set time of song, depending on position of mouse
        timeFromOffset(e, this) 
      }
    });

    $(".playbackBar .progressBar").mouseup(function(e) {
      
      timeFromOffset(e, this);
      
    });

    $(".volumeBar .progressBar").mousedown(function() {
      mouseDown = true;
    });

    $(".volumeBar .progressBar").mousemove(function(e) {
      if (mouseDown) {
        //Set time of song, depending on position of mouse
        var percentage = e.offsetX / $(this).width();

        if(percentage >= 0 && percentage <= 1) {
          audioElement.audio.volume = percentage;

        }
      }
    });

    $(".volumeBar .progressBar").mouseup(function(e) {
      
      var percentage = e.offsetX / $(this).width();
      if(percentage >= 0 && percentage <= 1) {
          audioElement.audio.volume = percentage;

      }
      
    });

    $(document).mouseup(function() {
      mouseDown = false;
    })

  });

  function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
  }

  function prevSong() {
    if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
      audioElement.setTime(0);
    } else {
      currentIndex = currentIndex - 1;
      setTrack(currentPlayList[currentIndex], currentPlayList, true);
    }
  }

  function nextSong() {
    if(repeat) {
      audioElement.setTime(0);
      playSong();
      return;
    }

    if(currentIndex == currentPlayList.length - 1) {
      currentIndex = 0;
    }
    else {
      currentIndex++;
    }

    var trackToPlay = shuffle ? shufflePlayList[currentIndex] : currentPlayList[currentIndex];
    setTrack(trackToPlay, currentPlayList, true);
  }

  function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", `assets/images/icons/${imageName}`);
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", `assets/images/icons/${imageName}`);
  }

  function setShuffle() {
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", `assets/images/icons/${imageName}`);

    if(shuffle) {
      //randomize playlist
      shuffleArray(shufflePlayList);
      currentIndex = shufflePlayList.indexOf(audioElement.currentlyPlaying.id);
    } else {
      //shuffle has activated
      //go back to regular playlist
      currentIndex = currentPlayList.indexOf(audioElement.currentlyPlaying.id);
    }
  }

  function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

  function setTrack(trackId, newPlayList, play) {
    if(newPlayList != currentPlayList) {
      currentPlayList = newPlayList;
      shufflePlayList = currentPlayList.slice();
      shuffleArray(shufflePlayList);
    }

    if(shuffle) {
      currentIndex = shufflePlayList.indexOf(trackId);
    } else {
      currentIndex = currentPlayList.indexOf(trackId);

    }
    pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

      var track = JSON.parse(data);
      $(".trackName span").text(track.title);

      $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
        var artist = JSON.parse(data);
        $(".artistName span").text(artist.name);
      });

      $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
        var album = JSON.parse(data);
        $(".albumLink img").attr("src", album.artworkPath);
      });

      audioElement.setTrack(track);
    });

    if(play) {
      playSong();
    }
    
  }

  function playSong() {

    if(audioElement.audio.currentTime == 0) {
      $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });

    } 

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
  }

  function pauseSong() {
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
  }
</script>

<div id="nowPlayingBarContainer">
  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
      <div class="content">
        <span class="albumLink">
          <img class="albumArtwork" src="" alt="">
        </span>
        <div class="trackInfo">
          <span class="trackName">
            <span></span>
          </span>
          <span class="artistName">
            <span>Jim Wang</span>
          </span>
        </div>
      </div>
    </div>

    <div id="nowPlayingCenter">
      <div class="content playerControls">
        <div class="buttons">
          <button class="controlButton shuffle" title ="Shuffle button" onclick="setShuffle()">
            <img src="assets/images/icons/shuffle.png" alt="Shuffle">
          </button>
          <button class="controlButton previous" title ="Previous button" onclick="prevSong()">
            <img src="assets/images/icons/previous.png" alt="Previous">
          </button>
          <button class="controlButton play" title ="Play button" onclick="playSong()">
            <img src="assets/images/icons/play.png" alt="Play">
          </button>
          <button class="controlButton pause" title ="Pause button" onclick="pauseSong()">
            <img src="assets/images/icons/pause.png" alt="Pause">
          </button>
          <button class="controlButton next" title ="Next button" onclick="nextSong()">
            <img src="assets/images/icons/next.png" alt="Next">
          </button>
          <button class="controlButton repeat" title ="Repeat button" onclick="setRepeat()">
            <img src="assets/images/icons/repeat.png" alt="Repeat">
          </button>
        </div>
        
        <div class="playbackBar">
          <span class="progressTime current">0.00</span>
          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div>
          <span class="progressTime remaining">0.00</span>
        </div>
      </div>
    </div>

    <div id="nowPlayingRight">
      <div class="volumeBar">
        <button class="controlButton volume" title="Volume button" onclick="setMute()">
          <img src="assets/images/icons/volume.png" alt="Volume" alt="Volume">
        </button>
        <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>