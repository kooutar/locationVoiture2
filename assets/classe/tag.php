<?php
class tag{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajoutTag($name){
        $stmt=$this->db->prepare("INSERT  into tag(tag) value (:tagname) ");
       return $stmt->execute(['tagname'=>$name]);
    }
    function tagNameExist($tagName) :bool{
        $stmt=$this->db->prepare("SELECT tag FROM tag where  tag=:tagname");
         $result=$stmt->execute(['tagname'=>$tagName]);
         if($result){
            $results=$stmt->fetch();
            if($results['tag']==$tagName)
            {
                return true;
            }else{
                return false;
            }
         }else
          return false;
    }
    function getAlltag(){
        $stmt=$this->db->prepare("SELECT * from tag");
       $result= $stmt->execute();
       if($result)
        return $stmt->fetchAll();
       else 
         return [];

    }


}