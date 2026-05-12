(async () => {
    const mod = await import('./cookies.js');
    window.setCookie = mod.setCookie;
    window.getCookies = mod.getCookie;

let themeRadio = document.querySelectorAll('input[name="data-theme"]');
let currentTheme = getCookies('data-theme');
const timestampDays30 = 30 * 24 * 60 * 60 * 1000;

// Theme

if (currentTheme === 'dark') {
    themeRadio.item(0).checked = true;
    document.documentElement.setAttribute('data-theme', 'dark');
} else {
    themeRadio.item(1).checked = true;
    document.documentElement.removeAttribute('data-theme');
}; 

themeRadio.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'narrow') {
            document.documentElement.setAttribute('data-theme', 'dark');
            setCookie('data-theme', 'dark', timestampDays30);
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            setCookie('data-theme', 'light', timestampDays30);
        }
    });
});

})();

// Media Content Loader Variables
let selectedMediaItems = [];
let currentMediaTab = 'upload';

// Media Content Modal Functions
function openMediaContentWindow() {
    document.getElementById('mediaContentModal').style.display = 'flex';
    document.getElementById('mediaContentOverlay').style.display = 'block';
    loadMediaLibrary();
}

function closeMediaContentWindow() {
    document.getElementById('mediaContentModal').style.display = 'none';
    document.getElementById('mediaContentOverlay').style.display = 'none';
}

function switchMediaTab(tabName) {
    currentMediaTab = tabName;
    
    // Hide all tabs
    document.querySelectorAll('.media-tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + 'Tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

function handleDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('uploadArea').classList.add('dragover');
}

function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('uploadArea').classList.remove('dragover');
    
    const files = event.dataTransfer.files;
    handleFiles(files);
}

function handleFileSelect(event) {
    const files = event.target.files;
    handleFiles(files);
}

function handleFiles(files) {
    const uploadedFilesList = document.getElementById('uploadedFiles');
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const fileItem = document.createElement('div');
                fileItem.className = 'media-file-item';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'media-file-thumbnail';
                
                const info = document.createElement('div');
                info.style.marginLeft = '1rem';
                info.textContent = file.name;
                
                const selectBtn = document.createElement('button');
                selectBtn.type = 'button';
                selectBtn.className = 'media-file-select';
                selectBtn.textContent = 'Select';
                selectBtn.onclick = function() {
                    selectedMediaItems = [{
                        url: e.target.result,
                        alt: file.name.replace(/\.[^/.]+$/, ""),
                        type: 'upload'
                    }];
                    highlightSelectedMedia();
                };
                
                fileItem.appendChild(img);
                fileItem.appendChild(info);
                fileItem.appendChild(selectBtn);
                uploadedFilesList.appendChild(fileItem);
            };
            reader.readAsDataURL(file);
        }
    });
}

function addUrlMedia() {
    const url = document.getElementById('mediaUrl').value;
    const alt = document.getElementById('mediaAlt').value;
    
    if (!url) {
        alert('Please enter an image URL');
        return;
    }
    
    selectedMediaItems = [{
        url: url,
        alt: alt || 'Image',
        type: 'url'
    }];
    
    const preview = document.getElementById('urlPreview');
    preview.innerHTML = '';
    
    const img = document.createElement('img');
    img.src = url;
    img.onerror = function() {
        alert('Failed to load image. Please check the URL.');
        selectedMediaItems = [];
    };
    preview.appendChild(img);
    
    highlightSelectedMedia();
}

function loadMediaLibrary() {
    const libraryContents = document.getElementById('mediaLibraryContents');
    
    // Simulate loading media from /public/uploads
    // This would typically be an AJAX call to your backend
    libraryContents.innerHTML = `
        <p>Media library feature coming soon.</p>
        <p>Currently supported:</p>
        <ul style="text-align: left;">
            <li>Upload files directly</li>
            <li>Enter external image URLs</li>
        </ul>
    `;
}

function highlightSelectedMedia() {
    // Update UI to show selection
    document.querySelectorAll('.media-file-item').forEach(item => {
        item.style.borderColor = 'transparent';
    });
    
    document.querySelectorAll('.library-item').forEach(item => {
        item.classList.remove('selected');
    });
}

function confirmMediaSelection() {
    if (selectedMediaItems.length === 0) {
        alert('Please select media content');
        return;
    }
    
    const media = selectedMediaItems[0];
    const previewContainer = document.getElementById('previewContainer');
    
    // Clear existing previews
    previewContainer.innerHTML = '';
    
    // Create preview item
    const previewItem = document.createElement('div');
    previewItem.className = 'preview-item';
    
    const itemContent = document.createElement('div');
    itemContent.className = 'preview-item-content';
    
    const img = document.createElement('img');
    img.src = media.url;
    img.className = 'preview-item-image';
    img.alt = media.alt;
    
    const details = document.createElement('div');
    details.className = 'preview-item-details';
    
    const altText = document.createElement('div');
    altText.innerHTML = `<strong>Alt Text:</strong> ${media.alt}`;
    
    const urlText = document.createElement('div');
    urlText.className = 'preview-item-url';
    urlText.innerHTML = `<strong>URL:</strong> ${media.url}`;
    
    details.appendChild(altText);
    details.appendChild(urlText);
    
    itemContent.appendChild(img);
    itemContent.appendChild(details);
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'preview-remove-btn';
    removeBtn.textContent = 'Remove';
    removeBtn.onclick = function() {
        previewContainer.innerHTML = '';
        selectedMediaItems = [];
    };
    
    previewItem.appendChild(itemContent);
    previewItem.appendChild(removeBtn);
    
    previewContainer.appendChild(previewItem);
    
    // Store media data in hidden inputs for form submission
    createHiddenMediaInputs(media);
    
    closeMediaContentWindow();
}

function createHiddenMediaInputs(media) {
    // Remove existing hidden inputs
    const existingInputs = document.querySelectorAll('input[name^="media_"]');
    existingInputs.forEach(input => input.remove());
    
    // Create new hidden inputs to store media data
    const form = document.querySelector('form');
    
    const urlInput = document.createElement('input');
    urlInput.type = 'hidden';
    urlInput.name = 'media_url';
    urlInput.value = media.url;
    
    const altInput = document.createElement('input');
    altInput.type = 'hidden';
    altInput.name = 'media_alt';
    altInput.value = media.alt;
    
    form.appendChild(urlInput);
    form.appendChild(altInput);
}

// Generate slug function
function generateSlug() {
    const titleInputs = document.querySelectorAll('input[name^="title_"]');
    if (titleInputs.length === 0) return;
    
    const title = titleInputs[0].value;
    const slug = title
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    
    document.querySelector('input[name="slug"]').value = slug;
}