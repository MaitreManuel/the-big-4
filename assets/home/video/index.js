import './_video.scss';

import YouTubePlayer from 'youtube-player';

exports.player = () => {
  const div_video = document.querySelector('#player'),
    id_video = 'hRcu9G-C4FE';
  let player;

  player = YouTubePlayer(div_video, {
    videoId: id_video,
    playerVars: {
      rel: 0,
      controls: 0,
      showinfo: 0,
      autoplay: '1',
      loop: '1',
      modestbranding: 0,
    }
  });
  player.on('stateChange', e => {
    if (e.data === 0) {
      player.playVideo();
      document.querySelector('player').getElementById('movie_player').setVolume(0);
    }
  });
};
