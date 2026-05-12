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
    
    if (!url) {
        alert('Please enter an image URL');
        return;
    }
    
    selectedMediaItems = [{
        url: url,
        alt: 'Image',
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
    
    const urlText = document.createElement('div');
    urlText.className = 'preview-item-url';
    urlText.innerHTML = `<strong>URL:</strong> ${media.url}`;
    
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
        document.getElementById('imagePreviewUrlInput').value = '';
    };
    
    previewItem.appendChild(itemContent);
    previewItem.appendChild(removeBtn);
    
    previewContainer.appendChild(previewItem);
    
    // Store media data in hidden inputs for form submission
    createHiddenMediaInputs(media);
    
    closeMediaContentWindow();
}

function createHiddenMediaInputs(media) {
    // Set the image_preview_url hidden input
    const imagePreviewInput = document.getElementById('imagePreviewUrlInput');
    if (imagePreviewInput) {
        imagePreviewInput.value = media.url;
    }
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

// Enhanced Markdown Preview with better rendering
function markdownToHtml(markdown) {
    let html = markdown
        // Escape HTML special chars first (but not our markdown syntax)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        // Code blocks (``` ... ```)
        .replace(/```([^`]+)```/gim, '<pre><code>$1</code></pre>')
        // Headers
        .replace(/^### (.*?)$/gim, '<h3>$1</h3>')
        .replace(/^## (.*?)$/gim, '<h2>$1</h2>')
        .replace(/^# (.*?)$/gim, '<h1>$1</h1>')
        // Bold and italic
        .replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/gim, '<em>$1</em>')
        .replace(/__(.*?)__/gim, '<strong>$1</strong>')
        .replace(/_(.*?)_/gim, '<em>$1</em>')
        // Links and images
        .replace(/!\[([^\]]*)\]\(([^\)]+)\)/gim, '<img src="$2" alt="$1">')
        .replace(/\[([^\]]+)\]\(([^\)]+)\)/gim, '<a href="$2" target="_blank">$1</a>')
        // Inline code
        .replace(/`([^`]+)`/gim, '<code>$1</code>')
        // Lists
        .replace(/^\*\s(.+)$/gim, '<li>$1</li>')
        .replace(/^-\s(.+)$/gim, '<li>$1</li>')
        .replace(/^(\d+)\.\s(.+)$/gim, '<li>$2</li>')
        .replace(/(<li>.*<\/li>)/s, '<ul>$1</ul>')
        // Blockquotes
        .replace(/^&gt;\s(.*?)$/gim, '<blockquote>$1</blockquote>')
        // Line breaks
        .replace(/\n\n/gim, '</p><p>')
        .replace(/\n/gim, '<br>');
    
    return '<p>' + html + '</p>';
}

// Attach title input listeners for slug auto-generation
document.addEventListener('DOMContentLoaded', function() {
    const titleInputs = document.querySelectorAll('.title-input');
    titleInputs.forEach(input => {
        input.addEventListener('change', function() {
            generateSlug();
        });
    });
});
}