<?php
return array(
    'badRequest.ajaxOnly' => 'This page is designed for AJAX requests. '.
        'Please, don\'t access it directly.',
    'badRequest.postNotFound' => 'Application couldn\'t find specified post',
    'badRequest.commentNotFound' => 'Application couldn\'t find specified '.
        'comment',
    'badRequest.categoryNotEmpty' => 'Category {categoryTitle} isn\'t empty '.
        'and can\'t be deleted',
    'badRequest.noDataReceived' => 'Application expected POST data, but '.
        'nothing was received.',
    'badRequest.invalidFormat' => 'Invalid format specified.',
    'badRequest.invalidPageNumber' => 'Specified page number is invalid.',
    'badRequest.specifiedRssPageNumber' => 'RSS feed does not support paging',
    'notAuthorized.postOwnership' => 'You are trying to modify or delete post '.
        'that doesn\'t belong to you. You should be ashamed!',
    'internalServerError.dataIntegrityFailure' => 'Couldn\'t continue because '.
        'of data integrity failure. If you\'re site admin, check application '.
        'log for precise error description.',
    'internalServerError.missingFile' => 'Requested file could not be read.',
    'internalServerError.unexpectedDataType' => 'Couldn\'t continue because '.
        'of unexpected data received. If you\'re site admin, check '.
        'application log for precise error description, and, if possible, '.
        'send log contents to application vendor.',
);
