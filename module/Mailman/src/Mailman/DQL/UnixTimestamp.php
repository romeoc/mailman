<?php

namespace Mailman\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

class UnixTimestamp extends FunctionNode 
{
    public $timestamp;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'UNIX_TIMESTAMP(' 
            . $sqlWalker->walkStringPrimary($this->timestamp) 
            . ')';
    }

    public function parse(Parser $parser) 
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->timestamp = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}