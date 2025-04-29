var uploadform = document.querySelector("#uploadForm");
var rpt = document.querySelector('.reporter');
var barguy = document.querySelector('.progress');
var thebar = document.querySelector('#progressBar');
var outdiv = document.createElement('div');
outdiv.id = 'output';

// for the uploader page

if(rpt != undefined){rpt.appendChild(outdiv);}

if(uploadform != undefined){
    uploadform.addEventListener('submit', (e) => {
        e.preventDefault();
        // alert('submitting...');

        barguy.style.height = '12px';
        outdiv.textContent = 'initialising...';

        setTimeout(() => {
            let fdata = new FormData(uploadform);
            let xhr = new XMLHttpRequest();

            xhr.open("POST",uploadform.action,true);

            xhr.upload.addEventListener('progress',(e) => {
                if(e.lengthComputable){
                    let complete = (e.loaded / e.total) * 100;
                    thebar.style.width = `${complete}%`;
                    outdiv.innerHTML = `${Math.floor    (complete)}% complete`;
                }
            })

            xhr.onload = () => {
                if(xhr.status == 200){
                    outdiv.innerHTML = `${xhr.responseText}`;
                    outdiv.className = 'success';
                    console.log(`[${xhr.status} ${xhr.statusText}] request sent to ${uploadform.action} : ${xhr.responseText}`)

                    uploadform.reset();
                    resetbar();
                } else {
                    outdiv.className = 'success';
                    outdiv.innerHTML = `there was an error <b>[${xhr.status}]</b>`;
                }
            }

            xhr.send(fdata);
        }, 1200);
    })
}

function resetbar() {
    setTimeout(() => {
        barguy.style.height = '0';
        thebar.style.width = '0%';
    }, 400);
}

// for the uploads page

const fileTypes = [
    { ext: 'jpg', type: 'image' },
    { ext: 'jpeg', type: 'image' },
    { ext: 'png', type: 'image' },
    { ext: 'gif', type: 'image' },
    { ext: 'webp', type: 'image' },
    { ext: 'svg', type: 'image' },
    { ext: 'mp4', type: 'video' },
    { ext: 'mov', type: 'video' },
    { ext: 'avi', type: 'video' },
    { ext: 'mkv', type: 'video' },
    { ext: 'mp3', type: 'audio' },
    { ext: 'wav', type: 'audio' },
    { ext: 'flac', type: 'audio' },
    { ext: 'doc', type: 'document' },
    { ext: 'docx', type: 'document' },
    { ext: 'pdf', type: 'document' },
    { ext: 'xls', type: 'spreadsheet' },
    { ext: 'xlsx', type: 'spreadsheet' },
    { ext: 'ppt', type: 'presentation' },
    { ext: 'pptx', type: 'presentation' },
    { ext: 'txt', type: 'text' },
    { ext: 'zip', type: 'archive' },
    { ext: 'rar', type: 'archive' },
    { ext: '7z', type: 'archive' },
    { ext: 'tar', type: 'archive' },
    { ext: 'gz', type: 'archive' },
    { ext: 'cmblock', type: 'cm datablock'}
];

function findfiletype(fname) {
    let tmp = fname.split(".");
    let ext = tmp[tmp.length - 1];
    let found = 0,thetype = "other";

    fileTypes.forEach(el => {
        if(el.ext == ext && found == 0){
            thetype = el.type;
            found += 1;
        }
    });

    return thetype;
}
