<main class="admin-edit-panel">
    <div class="edit-header">
        <h1>Text Redactor</h1>
        <div class="edit-actions">
            <a href="/content" class="btn btn-secondary">← Back to Posts</a>
        </div>
    </div>

    <form method="POST" action="/content/<?php echo htmlspecialchars($post['id']); ?>/update" class="edit-form">
        <!-- Post Metadata Section -->
        <section class="form-section">
            <h2>Post Settings</h2>
            <div class="form-group">
                <label for="slug">Slug</label>
                <div class="slug-input-group">
                    <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($post['slug'] ?? ''); ?>" required>
                    <button type="button" class="btn btn-sm" onclick="generateSlug()">Auto-generate</button>
                </div>
            </div>

            <div class="form-group">
                <label>Preview Image</label>
                <div class="image-selector">
                    <div class="image-preview" id="previewContainer">
                        <?php if (!empty($post['image_preview_url'])): ?>
                            <img src="<?php echo htmlspecialchars($post['image_preview_url']); ?>" alt="Preview Image">
                            <button type="button" class="btn btn-sm btn-error" onclick="clearPreviewImage()">Remove</button>
                        <?php else: ?>
                            <p class="no-image">No preview image</p>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="openMediaContentWindow()">Change Image</button>
                </div>
                <input type="hidden" name="image_preview_url" id="imagePreviewUrlInput" value="<?php echo htmlspecialchars($post['image_preview_url'] ?? ''); ?>">
            </div>
        </section>

        <!-- Language Tabs Section -->
        <section class="form-section">
            <h2>Content Translations</h2>
            
            <div class="language-tabs">
                <?php if (isset($locales)): ?>
                    <?php foreach ($locales as $index => $locale): ?>
                        <button type="button" class="lang-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                                data-locale="<?php echo htmlspecialchars($locale); ?>">
                            <?php echo strtoupper($locale); ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="language-content">
                <?php if (isset($locales)): ?>
                    <?php foreach ($locales as $index => $locale): ?>
                        <div class="lang-panel" data-locale="<?php echo htmlspecialchars($locale); ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                            <?php 
                            $translation = ($post['translations'][$locale] ?? null) ?: [];
                            $title = htmlspecialchars($translation['title'] ?? '');
                            $content = htmlspecialchars($translation['content_md'] ?? '');
                            ?>
                            
                            <div class="form-group">
                                <label for="title_<?php echo $locale; ?>">Title</label>
                                <input type="text" id="title_<?php echo $locale; ?>" name="title_<?php echo $locale; ?>" 
                                       value="<?php echo $title; ?>" required class="title-input" 
                                       data-locale="<?php echo $locale; ?>">
                            </div>

                            <div class="md-editor-container">
                                <div class="md-editor-toolbar">
                                    <div class="toolbar-group">
                                        <button type="button" class="md-btn" title="Bold" onclick="insertMarkdown('**', '**', 'content_<?php echo $locale; ?>')">
                                            <strong>B</strong>
                                        </button>
                                        <button type="button" class="md-btn" title="Italic" onclick="insertMarkdown('*', '*', 'content_<?php echo $locale; ?>')">
                                            <em>I</em>
                                        </button>
                                        <button type="button" class="md-btn" title="Heading" onclick="insertMarkdown('# ', '', 'content_<?php echo $locale; ?>')">
                                            H
                                        </button>
                                    </div>
                                    <div class="toolbar-group">
                                        <button type="button" class="md-btn" title="Link" onclick="insertMarkdown('[', '](url)', 'content_<?php echo $locale; ?>')">
                                            🔗
                                        </button>
                                        <button type="button" class="md-btn" title="Image" onclick="insertMarkdown('![alt](', ')', 'content_<?php echo $locale; ?>')">
                                            🖼️
                                        </button>
                                        <button type="button" class="md-btn" title="Code" onclick="insertMarkdown('`', '`', 'content_<?php echo $locale; ?>')">
                                            &lt;&gt;
                                        </button>
                                    </div>
                                    <div class="toolbar-group">
                                        <button type="button" class="md-btn" title="List" onclick="insertMarkdown('- ', '', 'content_<?php echo $locale; ?>')">
                                            ≡
                                        </button>
                                        <button type="button" class="md-btn" title="Quote" onclick="insertMarkdown('> ', '', 'content_<?php echo $locale; ?>')">
                                            &quot;
                                        </button>
                                    </div>
                                </div>

                                <div class="md-editor-wrapper">
                                    <textarea id="content_<?php echo $locale; ?>" name="content_<?php echo $locale; ?>" 
                                              class="md-textarea" data-locale="<?php echo $locale; ?>" 
                                              required><?php echo $content; ?></textarea>
                                    <div class="md-preview" id="preview_<?php echo $locale; ?>" class="md-preview-pane"></div>
                                </div>
                                <p class="md-hint">Supports Markdown syntax • Preview updates as you type</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Form Actions -->
        <section class="form-section form-actions">
            <button type="submit" class="btn btn-primary btn-lg">Update Post</button>
            <a href="/content" class="btn btn-secondary btn-lg">Cancel</a>
        </section>
    </form>

    <!-- Media Content Modal -->
    <div id="mediaContentModal" class="media-content-modal" style="display:none;">
        <div class="media-content-modal-content">
            <div class="modal-header">
                <h2>Media Content Loader</h2>
                <button type="button" class="modal-close" onclick="closeMediaContentWindow()">&times;</button>
            </div>
            
            <div class="modal-body">
                <div class="media-tabs">
                    <button type="button" class="tab-btn active" onclick="switchMediaTab('upload')">Upload File</button>
                    <button type="button" class="tab-btn" onclick="switchMediaTab('url')">Enter URL</button>
                    <button type="button" class="tab-btn" onclick="switchMediaTab('library')">Media Library</button>
                </div>

                <div id="uploadTab" class="media-tab-content active">
                    <div class="upload-area" id="uploadArea" ondrop="handleDrop(event)" ondragover="handleDragOver(event)">
                        <p>Drag files here or click to select</p>
                        <input type="file" id="fileInput" accept="image/*" multiple style="display:none;" onchange="handleFileSelect(event)">
                        <button type="button" class="upload-btn" onclick="document.getElementById('fileInput').click()">Choose Files</button>
                    </div>
                    <div id="uploadProgress" style="display:none;">
                        <p>Uploading: <span id="uploadStatus">0%</span></p>
                    </div>
                    <div id="uploadedFiles" class="uploaded-files-list"></div>
                </div>

                <div id="urlTab" class="media-tab-content" style="display:none;">
                    <div class="url-input-group">
                        <label for="mediaUrl">Image URL:</label>
                        <input type="text" id="mediaUrl" placeholder="Enter image URL...">
                        <label for="mediaAlt">Alt Text:</label>
                        <input type="text" id="mediaAlt" placeholder="Enter alt text...">
                        <button type="button" class="submit-btn" onclick="addUrlMedia()">Add Image</button>
                    </div>
                    <div id="urlPreview" class="url-preview" style="margin-top: 20px;"></div>
                </div>

                <div id="libraryTab" class="media-tab-content" style="display:none;">
                    <div class="media-library">
                        <div id="mediaLibraryContents" class="library-grid">
                            <p>Loading media library...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="cancel-btn" onclick="closeMediaContentWindow()">Cancel</button>
                <button type="button" class="confirm-btn" onclick="confirmMediaSelection()">Use Selected</button>
            </div>
        </div>
    </div>

    <div id="mediaContentOverlay" class="modal-overlay" style="display:none;" onclick="closeMediaContentWindow()"></div>
</main>

<script>
// Simple Markdown Preview using improved renderer
function updatePreview(locale) {
    const textarea = document.getElementById('content_' + locale);
    const preview = document.getElementById('preview_' + locale);
    if (!textarea || !preview) return;
    
    const markdown = textarea.value;
    const html = markdownToHtml(markdown);
    preview.innerHTML = html;
}

// Insert Markdown syntax
function insertMarkdown(before, after, textareaId) {
    const textarea = document.getElementById(textareaId);
    if (!textarea) return;
    
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selected = textarea.value.substring(start, end);
    const replacement = before + selected + after;
    
    textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
    textarea.selectionStart = textarea.selectionEnd = start + before.length + selected.length;
    textarea.focus();
    
    const locale = textareaId.replace('content_', '');
    updatePreview(locale);
}

// Language tab switching
document.addEventListener('DOMContentLoaded', function() {
    // Setup language tabs
    document.querySelectorAll('.lang-tab').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const locale = this.dataset.locale;
            
            document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelectorAll('.lang-panel').forEach(panel => {
                panel.style.display = panel.dataset.locale === locale ? 'block' : 'none';
            });
            
            // Give it a moment for display to update
            setTimeout(() => updatePreview(locale), 10);
        });
    });
    
    // Setup markdown preview on input
    document.querySelectorAll('.md-textarea').forEach(textarea => {
        const locale = textarea.dataset.locale;
        
        textarea.addEventListener('input', function() {
            updatePreview(locale);
        });
        
        // Initial preview
        updatePreview(locale);
    });
});

function clearPreviewImage() {
    document.getElementById('imagePreviewUrlInput').value = '';
    document.getElementById('previewContainer').innerHTML = '<p class="no-image">No preview image</p>';
}
</script>
