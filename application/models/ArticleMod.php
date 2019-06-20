<?php
class ArticleMod extends CI_Model {


	// SELECT `article_ID`, `article_title`, `article_subject`, `article_Doc_ID`, `new` FROM `article` WHERE 1
		
	public function getArticle($questionID)
	{
		$this->load->model('security',"sec");
		$this->load->model("doctorMod","docMod");
		$this->db->where('article_ID',$questionID);
		$this->db->select('*');
		$this->db->from('article');
		$res = $this->db->get();
		$data = [];
		foreach ($res->result() as $row)
		{
			$data['article_ID'] = $this->sec->encode($row->article_ID);
			$data['article_title'] = $row->article_title;
			$data['article_subject'] = $row->article_subject;
			$data['time'] = $row->ArticleDate;
			$data['img'] = $row->img;
			$data['writer'] = $this->docMod->getDoctorName($row->article_Doc_ID);
		} 
		return $data;
	}

	public function getallArticle()
	{
		$this->load->model('security',"sec");
		$this->load->model("doctorMod","docMod");
		$this->db->select('article_ID');
		$this->db->select('article_title');
		$this->db->select('img');
		$this->db->select('LEFT(article_subject, 200) as subject');
		$this->db->select('article_Doc_ID');
		$this->db->select('ArticleDate');
		$this->db->from('article');
		$res = $this->db->get();
		$data = [];
		$i = 0;
		$url = base_url()."Articlecont/Article/"; 
		foreach ($res->result() as $row)
		{
			$data['url'][$i] =$url.$this->sec->encode($row->article_ID);
			$data['articleid'][$i] =$this->sec->encode($row->article_ID);
			$data['article_title'][$i] = $row->article_title;
			$data['article_subject'][$i] = $row->subject."...";
			$data['time'][$i] = $row->ArticleDate;
			$data['img'][$i] = $row->img;
			$data['writer'][$i] = $this->docMod->getDoctorName($row->article_Doc_ID);
			$i++;
		} 
		return $data;
	}

	public function getmyArticles($docId)
	{
		$this->load->model('security',"sec");
		$this->load->model("doctorMod","docMod");
		$this->db->select('article_ID');
		$this->db->select('article_title');
		$this->db->select('img');
		$this->db->select('LEFT(article_subject, 200) as subject');
		$this->db->select('article_Doc_ID');
		$this->db->select('ArticleDate');
		$this->db->where('article_Doc_ID',$docId);
		$this->db->from('article');
		$res = $this->db->get();
		$data = [];
		$i = 0;
		$url = base_url()."Articlecont/Article/"; 
		foreach ($res->result() as $row)
		{
			$AID = $row->article_ID;
			$data['url'][$i] =$url.$this->sec->encode($AID);
			$data['articleid'][$i] =$this->sec->encode($AID);
			$data['article_title'][$i] = $row->article_title;
			$data['article_subject'][$i] = $row->subject."...";
			$data['time'][$i] = $row->ArticleDate;
			$data['img'][$i] = $row->img;
			$i++;
		} 
		return $data;
	}



	public function writeArticle($article)
	{
		$this->db->insert('article',$article);
		return $this->db->insert_id();
	}


	public function updateArticle($articleID , $article)
	{
		$this->db->where('article_ID',$articleID);
        $this->db->update('article', $article);
	}


	public function deleteArticle($articleID)
	{
		$this->db->where('article_ID',$articleID);
        $this->db->delete('article');
	}


	
	public function HasPermissiontoDeleteArticle($articleid,$DID){
		$this->db->where('article_ID',$articleid);
		$this->db->where('article_Doc_ID',$DID);
		$this->db->select('*');
		$this->db->from('article');
		$res = $this->db->get();
		if($res->num_rows() > 0){
			return true;
		}
		return false;
	}

	


}
?>
