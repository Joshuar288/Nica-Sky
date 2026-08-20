

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('carousell-1');
    const next = document.getElementById('btn-next');
    const prev = document.getElementById('btn-prev');
    const track2 = document.getElementById('carousell-2');
    const next2 = document.getElementById('btn-next2');
    const prev2 = document.getElementById('btn-prev2');

    if (track && next && prev) {
        next.addEventListener('click', () => {
            const maxSroll = track.scrollWidth - track.clientWidth;

            if (Math.ceil(track.scrollLeft) >= maxSroll - 10) {
                track.scrollTo({left: 0, behavior: 'smooth'});
            } else {
                track.scrollBy({left: track.offsetWidth, behavior: 'smooth'});
            }
        });

        prev.addEventListener('click', () => {
            const isStart = track.scrollLeft <= 5;

            if (isStart) {
                track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: -track.offsetWidth, behavior: 'smooth' });
            }
        })
    }

    if (track2 && next2 && prev2) {
        next2.addEventListener('click', () => {
            const maxSroll = track2.scrollWidth - track2.clientWidth;

            if (Math.ceil(track2.scrollLeft) >= maxSroll - 10) {
                track2.scrollTo({left: 0, behavior: 'smooth'});
            } else {
                track2.scrollBy({left: track2.offsetWidth, behavior: 'smooth'});
            }
        });

        prev2.addEventListener('click', () => {
            const isStart = track2.scrollLeft <= 5;

            if (isStart) {
                track2.scrollTo({ left: track2.scrollWidth, behavior: 'smooth' });
            } else {
                track2.scrollBy({ left: -track2.offsetWidth, behavior: 'smooth' });
            }
        })
    }
})
