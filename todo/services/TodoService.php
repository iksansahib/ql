<?php
namespace App\Service;

class TodoService{
    private $file_json = "../todo.json";
    private $config_json = "../config.json";
    public function getTodo($id=""){
        $json = json_decode(file_get_contents($this->file_json), true);
        if($id!=""){
            foreach($json as $k=>$v){
                if($v['id']==$id){
                    return [$json[$k]];
                }
            }
            return [];
        }
        return $json;
    }

    public function deleteTodo($id){
        $json = json_decode(file_get_contents($this->file_json), true);
        $new_json = [];
        $deleted = 0;
        foreach($json as $k=>$v){
            if($v['id']!=$id){
                $new_json[] = $v;
            } else {
                $deleted = 1;
            }
        }
        if($deleted){
            file_put_contents($this->file_json, json_encode($new_json));
            $new_json_from_file = json_decode(file_get_contents($this->file_json), true);
        }
        return $new_json_from_file ? $new_json_from_file : array("message"=>"Tidak ada yang dihapus");
    }

    public function addTodo($todo){
        if(empty($todo['title'])){
            return array("message"=>"Title is mandatory");
        }
        $json = json_decode(file_get_contents($this->file_json), true);
        $config = json_decode(file_get_contents($this->config_json), true);
        $lastId = $config['lastId'];
        $todo_object = new \stdClass();
        $todo_object->id = $lastId+1;
        $todo_object->title = $todo['title'];
        $todo_object->description = $todo['description'];
        $config['lastId'] = $todo_object->id;
        $json[] = $todo_object;
        file_put_contents($this->file_json, json_encode($json));
        file_put_contents($this->config_json, json_encode($config));
        $new_json_from_file = json_decode(file_get_contents($this->file_json), true);

        return $new_json_from_file;
    }

    public function updateTodo($id,$todo){
        if(empty($todo['title']) || empty($todo['description'])){
            return array("message"=>"Field tidak sesuai");
        }
        $json = json_decode(file_get_contents($this->file_json), true);
        $todo_object = new \stdClass();
        $todo_object->id = $id;
        $todo_object->title = $todo['title'];
        $todo_object->description = $todo['description'];
        
        foreach($json as $k=>$v){
            if($v['id']==$id){
                $json[$k] = $todo_object;
            }
        }
        file_put_contents($this->file_json, json_encode($json));
        $new_json_from_file = json_decode(file_get_contents($this->file_json), true);

        return $new_json_from_file;
    }
}