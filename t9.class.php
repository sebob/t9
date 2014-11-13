<?php
include_once 'tree.class.php';

class T9 
{
    public $tree;
    const DICTIONARY = "dictionary.txt"; //dictionary file
    
    public $key = array(
        '2'   => 'abc',
        '3'   => 'def', //f
        '4'   => 'ghi',
        '5'   => 'jkl', //l
        '6'   => 'mno', //o 
        '7'   => 'pqrs',
        '8'   => 'tuv',
        '9'   => 'wxyz',//w
        '0'   => 'o', //(but number is 3 and 5 and 0 and 9), correct numer is 3569
    );
    
    public function __construct() {
        $this->tree = new Tree();
    }
    
    /**
     * 
     * @param string $file - path to file
     * @param array $prefix (keys keyboard - a,b,c = 2)
     */
    public function addDictionary($file = self::DICTIONARY, $prefix = array())
    {        
        $dictionary = file_get_contents($file);
        $words = explode("\n", $dictionary);
        foreach ($words as $word) {
            if ($word != '') {
                /**
                 * Add word if character exist in string
                 * 3 = [d,e,f] so correct is (delf, eight, fly) words from dictionary
                 */
                if (in_array($word[0], $prefix)) { 
                    $this->tree->add($word);
                }
            }
        }
        unset($words);
    }
    
    /**
     * Method return all matching words from dictionary
     * @param int $input
     * @return array
     */
    public function getWords($input)
    {
        $searchWords = $this->getAllPatternsFromInput($input);
        
        $result = array();
        foreach ($searchWords as $word) {
            $tmp = $this->tree->prefixSearch($word);
            if (is_array($tmp)) {
                $result = array_merge($result, array_keys($tmp));
            }
        }
        return array_unique($result);
    }
    
    /**
     * 
     * @param string $input
     * @return array
     */
    public function getAllPatternsFromInput($input)
    {
        $patterns = array();
        $numbers = str_split($input);
        
        $validNumbers = array_keys($this->key);
        foreach ($numbers as $number) {
            if (in_array($number, $validNumbers)) { //compare $number to valid numbers
                $reversedChars = str_split($this->key[$number]);
                $patterns = $this->appendChars($patterns, $reversedChars);
            }
        }
        
        return $patterns;
    }
    
    /**
     * 
     * @param array $patterns
     * @param array $chars
     * @return array
     */
    private function appendChars($patterns, $chars = array())
    {
        $newPatterns = array();
        if (count($patterns) == 0) {
            return $chars;
        }
        foreach ($patterns as $pattern) {
            foreach ($chars as $char) {
                
                $newPatterns[] = $pattern . $char;
            }
        }
        
        return $newPatterns;
    }
}

?>