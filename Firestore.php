<?php

require_once 'vendor/autoload.php';
use Google\Cloud\Firestore\FirestoreClient;

class Firestore 
{
    protected $db;
    protected $name;
    public function __construct(string $collection)
    {
        $this->db = new FirestoreClient([
            'projectId' => 'FIREBASE_PROJECT_ID'
        ]);

        $this->name = $collection;
    }
//function to get data on the basis of firebase ID of any collection 
    public function getDocument(string $name)
    {
        try {
            if ($this->db->collection($this->name)->document($name)->snapshot()->exists()) {
                return $this->db->collection($this->name)->document($name)->snapshot()->data();
            } else {
                throw new Exception("no data found", 1);
                
            }

        } catch (Exception $exception) {
    
            return $exception->getMessage();
        }

    }

//function to get data based on any condition
    public function getOnCondition(string $feild, string $operator, string $value)
    {
        $array = [];
        $query = $this->db->collection($this->name)->where($feild,$operator,$value)->documents()->rows();
        if (!empty($query)) {

            foreach ($query as $item ) {
                $array[] = $item->data();
                $json = json_encode($array);
               //print_r($array);
            }
            
        }
        return $json;

    }
// function to add new document
    public function createNewDocument(string $name, array $data = [])
    {
        try {
            $this->db->collection($this->name)->document($name)->create($data);
            return true;

        } catch (Exception $exception) {
            return $exception->getMessage();
            //throw $th;


        }

    }

//fucntion to create new collection
    public function createNewCollection(string $name, string $document_name, array $data = [])
    {
        try {
            $this->db->collection($name)->document($document_name)->create($data);
            return true;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }


    }

//function to drop a document
    public function deleteDocument(string $name)
    {
        $this->db->collection($this->name)->document($name)->delete();
    }

//function to delete collection
    public function deleteCollection(string $name)
    {
        $doc = $this->db->collection($name)->limit(3)->documents();
        while (!$doc->isEmpty()) {

            foreach ($$doc as $item ) {
                $item->reference()->delete();
            }
        }
    }

//function to get all documents of a collection
    public function getAllDocument()
    {
        $array = [];
        //$array1 = [];
        
        $all = $this->db->collection($this->name)->documents();
        foreach ($all as $item) {
            
            if ($item ->exists()) {
                    //printf($item->id());
                    //print_r($item->data());
                    //printf(PHP_EOL);
                   // $array1[] = $item->id();
                    $array[] = $item->data();
                    $json = json_encode($array);
            }else {
                printf('Document %s does not exist!');
            }
        }
        return $json;
        //return $array1;
    }

    
}