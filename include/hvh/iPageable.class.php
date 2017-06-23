<?php
namespace hvh {

interface iPageable {
	public function GetRadisHKey();
	public function GetRadisTTL();
    public function GetCount();
    public function GetDataList($pParamArray);
}
}// End of namespace
?>