// AR: فتح/إغلاق السايدبار بالموبايل | EN: toggle sidebar | SA: افتح/اقفل الشريط
const burger = document.querySelector("[data-burger]");
const sidebar = document.querySelector("[data-sidebar]");
const overlay = document.querySelector("[data-overlay]");

function openSide(){
  if(sidebar){ sidebar.classList.add("open"); }
  if(overlay){ overlay.style.display="block"; }
}
function closeSide(){
  if(sidebar){ sidebar.classList.remove("open"); }
  if(overlay){ overlay.style.display="none"; }
}

if(burger){ burger.addEventListener("click", openSide); }
if(overlay){ overlay.addEventListener("click", closeSide); }
