var Timer;
var TotalSeconds;

function CreateTimer(TimerID, Time, callback, params) {
   Timer = document.getElementById(TimerID);
   TotalSeconds = Time;

   UpdateTimer();

   if (params != '') {
      callback += ", " + params;
   }

   window.setTimeout("Tick(" + callback + ")", 1000);
}

function Tick(callback, params) {
   if (TotalSeconds <= 0) {
      return callback(params);
   }

   TotalSeconds -= 1;

console.log("callback: " + callback);
   // todo: refactor so not code specific
   if (callback == 'enterGame') {
      UpdateTimerSeconds();
   } else {
      UpdateTimer();
   }
   window.setTimeout("Tick(" + callback + ")", 1000);
}

function UpdateTimerSeconds() {
   Timer.innerHTML = TotalSeconds;
}

function UpdateTimer() {
   var Seconds = TotalSeconds;

   var Days = Math.floor(Seconds / 86400);
   Seconds -= Days * 86400;

   var Hours = Math.floor(Seconds / 3600);
   Seconds -= Hours * 3600;

   var Minutes = Math.floor(Seconds / 60);
   Seconds -= Minutes * (60);

   // var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds);
   var TimeStr = Days + " days, " + Hours + " hours, " + Minutes + " minutes, and " + Seconds + " seconds";

   Timer.innerHTML = TimeStr;
}

function LeadingZero(Time) {
   return (Time < 10) ? "0" + Time : + Time;
}
