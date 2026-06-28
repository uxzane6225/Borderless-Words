const menu = document.getElementById("menu");
const menuBtn = document.querySelectorAll(".menuBtn");

const editProfileContent = document.getElementById("editProfileContent");
const settingContent = document.getElementById("settingContent");
const hiresContent = document.getElementById("hiresContent");
const jobsContent = document.getElementById("jobsContent");
const requestContent = document.getElementById("requestContent");

menuBtn.forEach(btn => {
	btn.addEventListener("click", event => {
		const dataPage = btn.getAttribute("data-page");
		
		switch (dataPage) {
			case "editProfile":
				editProfileContent.classList.remove("hidden");
				settingContent.classList.add("hidden");
				hiresContent.classList.add("hidden");
				jobsContent.classList.add("hidden");
				requestContent.classList.add("hidden");
				break;
			case "settings":
				editProfileContent.classList.add("hidden");
				settingContent.classList.remove("hidden");
				hiresContent.classList.add("hidden");
				jobsContent.classList.add("hidden");
				requestContent.classList.add("hidden");
				break;
			case "hires":
				editProfileContent.classList.add("hidden");
				settingContent.classList.add("hidden");
				hiresContent.classList.remove("hidden");
				jobsContent.classList.add("hidden");
				requestContent.classList.add("hidden");
				break;
			case "jobs":
				editProfileContent.classList.add("hidden");
				settingContent.classList.add("hidden");
				hiresContent.classList.add("hidden");
				jobsContent.classList.remove("hidden");
				requestContent.classList.add("hidden");
				break;
			case "hireReq":
				editProfileContent.classList.add("hidden");
				settingContent.classList.add("hidden");
				hiresContent.classList.add("hidden");
				jobsContent.classList.add("hidden");
				requestContent.classList.remove("hidden");
				break;
			default:
				console.log("huh?");
				break;
		}
	});
});