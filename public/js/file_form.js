// let fileInput = document.getElementById("file-input");
// let fileList = document.getElementById("files-list");
// let numOfFiles = document.getElementById("num-of-files");

// fileInput.addEventListener("change", () => {
//     fileList.innerHTML = "";
//     numOfFiles.textContent = `Đã chọn ${fileInput.files.length} ảnh`;

//     for (i of fileInput.files) {
//         let reader = new FileReader();
//         let listItem = document.createElement("li");
//         let fileName = i.name;
//         let fileSize = (i.size / 1024).toFixed(1);
//         listItem.innerHTML = `<p>${fileName}</p><p>${fileSize}KB</p>`;
//         if (fileSize >= 1024) {
//             fileSize = (fileSize / 1024).toFixed(1);
//             listItem.innerHTML = `<p>${fileName}</p><p>${fileSize}MB</p>`;
//         }
//         fileList.appendChild(listItem);
//     }
// });
let files = [],
dragArea = document.querySelector('.drag-area'),
input = document.querySelector('.drag-area input'),
button = document.querySelector('.card button'),
select = document.querySelector('.drag-area .select'),
container = document.querySelector('.container');

/** CLICK LISTENER */
select.addEventListener('click', () => input.click());

/* INPUT CHANGE EVENT */
input.addEventListener('change', () => {
	let file = input.files;
        
    // if user select no image
    if (file.length == 0) return;
         
	for(let i = 0; i < file.length; i++) {
        if (file[i].type.split("/")[0] != 'image') continue;
        if (!files.some(e => e.name == file[i].name)) files.push(file[i])
    }

	showImages();
});

/** SHOW IMAGES */
function showImages() {
	container.innerHTML = files.reduce((prev, curr, index) => {
		return `${prev}
		    <div class="image">
			    <span onclick="delImage(${index})">&times;</span>
			    <img src="${URL.createObjectURL(curr)}" />
			</div>`
	}, '');
}

/* DELETE IMAGE */
function delImage(index) {
   files.splice(index, 1);
   showImages();
}

/* DRAG & DROP */
dragArea.addEventListener('dragover', e => {
	e.preventDefault()
	dragArea.classList.add('dragover')
})

/* DRAG LEAVE */
dragArea.addEventListener('dragleave', e => {
	e.preventDefault()
	dragArea.classList.remove('dragover')
});

/* DROP EVENT */
dragArea.addEventListener('drop', e => {
	e.preventDefault()
    dragArea.classList.remove('dragover');

	let file = e.dataTransfer.files;
	for (let i = 0; i < file.length; i++) {
		/** Check selected file is image */
		if (file[i].type.split("/")[0] != 'image') continue;
		
		if (!files.some(e => e.name == file[i].name)) files.push(file[i])
	}
	showImages();
});
