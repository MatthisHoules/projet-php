/**
 * @title blog.js
 * 
 * @brief blog followers and following boxes display
 * 
 */



var followingB = document.getElementById('followingB');
var followerB = document.getElementById('followerB');
var closeFollowingC = document.getElementById('closeFollowingC');
var closeFollowerC = document.getElementById('closeFollowerC');

followingB.addEventListener('click', function() {
    document.getElementById('followC').classList.remove('nodisplay');
    document.getElementById('followingC').classList.remove('nodisplay');
});
closeFollowingC.addEventListener('click', function() {
    document.getElementById('followC').classList.add('nodisplay');
    document.getElementById('followingC').classList.add('nodisplay');
});


followerB.addEventListener('click', function() {
    document.getElementById('followC').classList.remove('nodisplay');
    document.getElementById('followerC').classList.remove('nodisplay');
});
closeFollowerC.addEventListener('click', function() {
    document.getElementById('followC').classList.add('nodisplay');
    document.getElementById('followerC').classList.add('nodisplay');
});

