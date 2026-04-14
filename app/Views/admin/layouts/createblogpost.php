<main>
    <form method="POST" action="/admin/posts/store">
        <?php 
        if (isset($locales)) {
            foreach ($locales as $locale) {
                $locale = htmlspecialchars(strtoupper($locale));
                echo "<h2>$locale</h2>";
                echo "<h3>Title</h3>";
                echo "<input type='text' name='title_$locale'><br>";
                echo "<h3>Content</h3>";
                echo "<textarea name='content_$locale'></textarea><br>";
            }
        } 
        ?>
        <label>Slug</label>
        <input type='text' name='slug' required>
        <button type='button' onclick='generateSlug()'>Generate Slug From Title</button><br>
        <div class="createpost-mediacontent">
            <h2>Media Content:</h2>
            <!-- Load any media files from drive and display them here with an option to select one as preview or content image, or allow admin to input URL of the image -->
            <!-- for using in md links ![alt text](image_url) or <img src="image_url" alt="alt text"> -->
            <div class="createpost-mediacontent-container">
                <div class="createpost-mediacontent-loadbutton">
                    <button type="button" onclick="openMediaContentWindow()">Add Media Content</button>
                </div>
                <h3>Preview Image:</h3>
                <div class="createpost-mediacontent-preview" id="previewContainer">
                    <?php ?>
                </div>        
            </div>
        </div>

        <!-- Media Content Window Modal -->
        <div id="mediaContentModal" class="media-content-modal" style="display:none;">
            <div class="media-content-modal-content">
                <div class="modal-header">
                    <h2>Media Content Loader</h2>
                    <button type="button" class="modal-close" onclick="closeMediaContentWindow()">&times;</button>
                </div>
                
                <div class="modal-body">
                    <!-- Tab Navigation -->
                    <div class="media-tabs">
                        <button type="button" class="tab-btn active" onclick="switchMediaTab('upload')">Upload File</button>
                        <button type="button" class="tab-btn" onclick="switchMediaTab('url')">Enter URL</button>
                        <button type="button" class="tab-btn" onclick="switchMediaTab('library')">Media Library</button>
                    </div>

                    <!-- Upload Tab -->
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

                    <!-- URL Tab -->
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

                    <!-- Library Tab -->
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

        <!-- Modal Overlay -->
        <div id="mediaContentOverlay" class="modal-overlay" style="display:none;" onclick="closeMediaContentWindow()"></div>

    </form>
</main>