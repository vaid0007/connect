<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Dynamic Folder Viewer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.1/css/font-awesome.css"
        integrity="sha512-bf5lgyUrZOfPh94XyXFK4+2062lAMQFAfxUTVkOAHZ7R3XQ0tY+TUSkbqt8sjFsq0hVMKvGT/1P39c+vKwesTQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    #folderPath {
        font-weight: bold;
    }

    .file-checkbox {
        display: none;
    }

    .show-checkbox .file-checkbox {
        display: block;
    }

    /* Disable text selection for the entire page */
    body {
        -webkit-user-select: none;
        /* Chrome, Safari, and Opera */
        -moz-user-select: none;
        /* Firefox */
        -ms-user-select: none;
        /* Internet Explorer/Edge */
        user-select: none;
        /* Non-prefixed version, currently supported by Chrome, Opera, and Edge */
    }

    /* Highlight selected items */
    .selected {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    </style>
</head>

<body>
    <div class="container-fluid my-2 disable-text-selection">
    </div>
    <div class="container-fluid my-2 disable-text-selection">
        <nav class="card bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <button id="reload" class="btn btn-dark p-0 mx-2 text-white">
                    <i class="fa fa-refresh p-1 mx-1" aria-hidden="true"></i>
                </button>
                <button id="backButton" class="btn btn-warning p-0 mx-2 text-white">
                    <i class="fa fa-arrow-left p-1 mx-1" aria-hidden="true"></i>
                </button>
                <span class="breadcrumb m-0 p-0" id="folderPath">
                    Path: /xampp/htdocs
                </span>
                <div class="ms-auto d-flex">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle bg-dark text-white mx-2" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Edit Mode
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="download"><i class="fa fa-download"></i>
                                    Download File</a></li>
                            <li data-bs-toggle="modal" data-bs-target="#uploadFilese"><a class="dropdown-item"
                                    href="#"><i class="fa fa-clipboard" aria-hidden="true"></i>
                                    Upload File</a></li>
                            <li id="delete"><a class="dropdown-item delete" href="#"><i class="fa fa-trash-o"></i>
                                    Delete</a></li>

                        </ul>
                    </div>
                    <button id="selectAllButton" class="btn btn-warning text-white">Select All</button>
                    <button id="deselectAllButton" class="btn btn-danger" style="display: none;">Deselect
                        All
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <div class="container-fluid mb-3">
        <div class="card bg-body-tertiary vh-100">
            <div class="card-body overflow-auto" style="height: 100%;" id="folderContainer">
                <ul class="list-unstyled d-flex flex-wrap" id="folderList">
                </ul>
            </div>
        </div>
    </div>


    <div class="modal fade" id="uploadFilese" tabindex="-1" aria-labelledby="uploadFilese" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="uploadFiles" enctype="multipart/form-data" method="post">
                        <input type="file" id="replacementFile" name="replacementFile" accept="*/*">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="uploadFilehere" class="btn btn-primary">Upload button</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var history = [];
        var currentPath = '../';
        var pressTimer;
        var selectedPaths = [];
        var lastPath = '';

        $('#folderList').on('dblclick', '.folder-item', function() {
            path = $(this).data('path');
            loadFolders(path);

        });
        $('#reload').on('click', function() {
            loadFolders(lastPath);
        });

        function loadFolders(path) {
            $.ajax({
                url: 'getFolders.php',
                method: 'GET',
                data: {
                    path: path
                },
                success: function(data) {
                    $('#folderList').html(data);
                    $('#folderPath').text('Path: ' + path);
                    lastPath = path;
                    updateButtonVisibility();

                    if (path !== currentPath) {
                        history.push(currentPath);
                        currentPath = path;
                    }
                },
                error: function() {
                    alert('Error loading folder contents.');
                }
            });
        }


        $('#uploadFilehere').on('click', function() {
            var formData = new FormData($('#uploadFiles')[0]);
            formData.append('path', lastPath);
            $.ajax({
                url: 'uploadFile.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            alert("File uploaded successfully.");
                            loadFolders(currentPath);
                            $('#uploadFilese').modal('hide');
                        } else {
                            alert("Error: " + jsonResponse?.message);
                        }
                    } catch (e) {
                        alert('Unexpected error: ' + e?.message);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText ||
                        'Error during upload operation.';
                    alert('Error: ' + errorMessage);
                }
            });
        });

        $('#delete').on('click', function() {
            if (selectedPaths.length === 0) {
                alert('No files or folders selected.');
                return;
            }

            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: {
                    paths: selectedPaths
                },
                success: function(response) {
                    try {
                        if (response.success) {
                            alert("Files and/or folders deleted successfully.");
                            loadFolders(currentPath);
                        } else {
                            alert("Error: " + response?.message);
                        }
                    } catch (e) {
                        alert('Unexpected error: ' + e?.message);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText || 'Error during delete operation.';
                    alert('Error: ' + errorMessage);
                }
            });
        });

        // Function to select files or folders
        function selectItem(path) {
            if (!selectedPaths.includes(path)) {
                selectedPaths.push(path);
            }
        }

        // Function to unselect files or folders
        function unselectItem(path) {
            var index = selectedPaths.indexOf(path);
            if (index > -1) {
                selectedPaths.splice(index, 1);
            }
        }

        // Function to load folders and files


        function updateButtonVisibility() {
            var anySelected = $('.file-item.show-checkbox, .folder-item.show-checkbox').length > 0;
            var allSelected = $('.file-item, .folder-item').length === $(
                '.file-item.show-checkbox, .folder-item.show-checkbox').length;

            if (allSelected) {
                $('#selectAllButton').hide();
                $('#deselectAllButton').show();
            } else if (anySelected) {
                $('#selectAllButton').hide();
                $('#deselectAllButton').show();
            } else {
                $('#selectAllButton').show();
                $('#deselectAllButton').hide();
            }
        }

        function updateSelectedPaths() {
            selectedPaths = [];
            $('.file-item.show-checkbox, .folder-item.show-checkbox').each(function() {
                selectedPaths.push($(this).data('path'));
            });
        }

        loadFolders(currentPath);

        $('#folderList').on('mousedown', '.folder-item, .file-item', function() {
            var item = $(this);
            pressTimer = window.setTimeout(function() {
                item.addClass('show-checkbox');
                updateSelectedPaths();
                updateButtonVisibility();
            }, 500);
        }).on('mouseup mouseleave', function() {
            clearTimeout(pressTimer);
        });



        $('#backButton').click(function() {
            if (history.length > 0) {
                var previousPath = history.pop();
                loadFolders(previousPath);
                currentPath = previousPath;
            }
        });

        $('#selectAllButton').click(function() {
            $('.file-item, .folder-item').each(function() {
                $(this).addClass('show-checkbox');
                $(this).find('.file-checkbox').prop('checked', true);
            });
            updateSelectedPaths();
            updateButtonVisibility();
        });

        $('#deselectAllButton').click(function() {
            $('.file-item, .folder-item').each(function() {
                $(this).removeClass('show-checkbox');
                $(this).find('.file-checkbox').prop('checked', false);
            });
            updateSelectedPaths();
            updateButtonVisibility();
        });

        $('#folderList').on('change', '.file-checkbox', function() {
            updateSelectedPaths();
            updateButtonVisibility();
        });

        $('#download').on('click', function() {
            if (selectedPaths.length === 0) {
                alert('No files selected.');
                return;
            }

            $.ajax({
                url: 'download.php',
                method: 'POST',
                data: {
                    files: selectedPaths
                },
                xhrFields: {
                    responseType: 'blob' // Expecting a blob response for file downloads
                },
                success: function(response, status, xhr) {
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition && disposition.indexOf('attachment') !== -1) {
                        var filename = disposition.split('filename=')[1].split(';')[0]
                            .replace(/"/g, '');
                        var link = document.createElement('a');
                        var url = window.URL.createObjectURL(response);
                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);
                    } else {
                        var reader = new FileReader();
                        reader.onload = function() {
                            try {
                                var jsonResponse = JSON.parse(reader.result);
                                if (!jsonResponse.success) {
                                    alert(jsonResponse.message ||
                                        'Error during download.');
                                }
                            } catch (e) {
                                alert('Unexpected error during download.');
                            }
                        };
                        reader.readAsText(response);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseText || 'Error during download.';
                    alert('Error: ' + errorMessage);
                }
            });
        });
    });
    </script>
</body>

</html>