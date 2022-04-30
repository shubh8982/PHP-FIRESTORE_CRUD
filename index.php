<?php

require_once 'Firestore.php';

$fs = new Firestore ('FIRESTORE_COLLECTION_NAME');
//print document with firebase ID
// print_r($fs->getDocument('xh5xSlrHdiLsFbHQcK62'));
//print data based on condition
//print_r($fs->getOnCondition('remaining_minuts','>','1000'));
//print_r($fs->createNewDocument('test',['name' => 'shubhanshu']));
//print_r($fs->createNewCollection('test-collection','test-document',[]));
//print_r($fs->deleteDocument('test-document'));
//print_r($fs->deleteCollection('test-collection'));
print_r($fs->getAllDocument());

