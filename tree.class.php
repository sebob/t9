<?php
/**
 * Implementation of trie tree (algorithm simplified)
 * 
 * Tree stored in the nodes of the tree fragments keys.
 * Trie data in the tree are the words found in the leaves.
 * 
 * Internal nodes are arrays of pointers to subtrees trie on
 * each level and check the corresponding index in the array
 * the i-th letter of the processed speech.
 * 
 * When the pointer disappears for this position is empty, 
 * then the word is not in the tree.
 * 
 * When the pointer is not empty, then continue processing until 
 * to achieve a leaf that contains the entire search word.
 * 
 * Help link: http://en.wikipedia.org/wiki/Trie
 */
class Tree {
    
    public $tree;
    public function __construct()
    {
        $this->tree = array('children' => array());
    }
    
    /**
     * Add word for example "ala"
     * Use reference to object $this->tree
     * @param string $key
     * @param string $value
     */
    public function add($key, $value = null)
    {
        $trieLevel = &$this->getForKey($key, true);
        $trieLevel['value'] = $value;
    }
    
    /**
     * Create tree
     * [l][a]
     * [d][a]
     * [a][b]
     * ...
     * @param string $key
     * @param boolean $create
     * @return array
     */
    private function &getForKey($key, $create = false)
    {   
        $trieLevel = &$this->tree;
        for ($i = 0; $i < strlen($key); $i++) {
            $character = $key[$i];
            if (!isset($trieLevel['children'][$character])) {
                if ($create) {
                    $trieLevel['children'][$character] = array('children' => array());
                } else {
                    return false;
                }
            }
            $trieLevel = &$trieLevel['children'][$character];
        }
        return $trieLevel;
    }
    
    /**
     * 
     * @param string $prefix
     * @return boolean
     */
    public function prefixSearch($prefix)
    {
        $trieLevel = $this->getForKey($prefix);
        
        if (false == $trieLevel) {
            return false;
        } else {
            return $this->getAllChildren($trieLevel, $prefix);
        }
    }
    
    /**
     * 
     * @param array $level
     * @param string $prefix
     * @return array
     */
    private function getAllChildren($level, $prefix)
    {
        $return = array();
        if (array_key_exists('value', $level)) {
            $return[$prefix] = $level['value'];
        }
        if (isset($level['children'])) {
            foreach ($level['children'] as $character => $trie) {
                $return = array_merge($return, $this->getAllChildren($trie, $prefix . $character));
            }
        }
        
        return $return;
    }
}