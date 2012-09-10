<?php

/* The LinkAttribute is actually just a pointer into the atLinks table
 * which contains one or more title/url pairs. Each pair has a position
 * and they are always returned in order.
 * getValue() presently returns an array of the items, but this may change
 * to return an object at some point.
 *
 * Thanks to Andrew Householder on IRC for the pointers on this.
 */
class LinkAttributeTypeController extends AttributeTypeController 
{
    /* Definition of the field that will be used for the attribute index
     * field. We create 2 fields, one for the titles and one for the actual
     * links. This allows both to be searchable and hopefully keep the
     * sizes to a manageable size.
     *     titles => long text with default of NULL
     *     links  => long text with default of NULL
     */
	protected $searchIndexFieldDefinition = array(
        'titles' => 'X NULL', 'links' => 'X NULL'
    );

    public function getValue() 
    {
		$db = Loader::db();
		$data = $db->getAll("SELECT * FROM atLinks WHERE avID = ? ORDER BY pos ASC", 
		                    array($this->getAttributeValueID()));
		return $data;
    }

    /* This function sets the data that will be stored for this attribute
     * in the index table (used for keyword search). As we can have multiple
     * title => link pairs per attribute, we take them all and basically
     * create a single string of titles and links. By defining the search
     * criteria above this should allow the standard C5 functions to
     * perform the search with no additional effort.
     */
    public function getSearchIndexValue()
    {
        $db = Loader::db();
        $titles = array();
        $links = array();
        $vals = $this->getValue();
        foreach($vals as $val) {
            $titles[] = $db->quote("'".$val['title']."'");
            $links[] = $db->quote("'".$val['link']."'");
        }
        return array('titles' => implode(",", $titles),
                       'links' => implode(",", $links));
    }

    public function form() 
    {
        $this->set('akID', $this->attributeKey->getAttributeKeyID());
        $this->set('links', $this->getValue());
    }


    private function updateRecord($linkID, $fields)
    {
		$db = Loader::db();
		if ($linkID > 0) {
            $data = array('linkID' => $linkID,
                           'avID' => $this->getAttributeValueID(),
                           'title' => $fields['title'],
                           'url' => $fields['url'], 
                           'pos' => $fields['pos']);
            $db->Replace('atLinks', $data, 'linkID', true);
        } else {
            $data = array($this->getAttributeValueID(),
                           $fields['title'],
                           $fields['url'],
                           $fields['pos']);
            $db->Execute("insert into atLinks (avID, title, url, pos) values (?,?,?,?)",
                         $data);
        }
    }

    public function saveValue($data)
    {
        /* This can be called instead of saveForm...
         * is it needed?
         */
    }
    
	public function saveForm($data) 
	{
        foreach($data as $id => $info) {
            if ($id == 'new') {
                foreach($data['new'] as $n) {
                    $this->updateRecord(0, $n);
                }
            } else {
                $id = intval($id);
                $this->updateRecord($id, $info);
            }
        }
	}
	
	public function deleteKey() 
	{
        $db = Loader::db();
        $arr = $this->attributeKey->getAttributeValueIDList();
        foreach($arr as $id) {
            $db->Execute('delete from atLinks where avID = ?', array($id));
        }
    }
}

?>
