<?php

/**
 * Copyright 2014 Fabian Grutschus. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * The views and conclusions contained in the software and documentation are those
 * of the authors and should not be interpreted as representing official policies,
 * either expressed or implied, of the copyright holders.
 *
 * @author    Fabian Grutschus <f.grutschus@lubyte.de>
 * @copyright 2014 Fabian Grutschus. All rights reserved.
 * @license   BSD
 * @link      http://github.com/fabiang/xmpp
 */

namespace Fabiang\Xmpp\Util;

use Fabiang\Xmpp\Exception\MalformedJidException;

/**
 * JID string utility methods.
 *
 * @package Xmpp\Util
 */
class JID
{
    private $node;
    private $domain;
    private $resource;

    public function __construct($jid=null)
    {
        !empty($jid) && $this->setJid($jid);
    }

    public function getJid()
    {
        return $this->_getJid(false);
    }

    private function _getJid($silentError=false)
    {
        return self::buildJid(
            $this->node,
            $this->domain,
            $this->resource,
            $silentError
        );
    }

    public function setJid($jid)
    {
        $jid = self::parseJid($jid);

        if(!$jid || empty($jid['domain'])){
            throw new MalformedJidException($jid);
        }

        $this->setNode($jid['node']);
        $this->setDomain($jid['domain']);
        $this->setResource($jid['resource']);
        return $this;
    }

    public function getNode()
    {
        return $this->node;
    }

    public function setNode($node)
    {
        $this->node = $node;
        return $this;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function __toString()
    {
        return $this->_getJid(true);
    }

    //
    // STATIC FUNCTIONS
    //
    public static function buildJid($node, $domain, $resource=null, $silentError=false)
    {
        $jid = '';
        if (!empty($node)){
            $jid .= $node . '@';
        }
        if (!empty($domain)){
            $jid .= $domain;
        } else if($silentError === false){
            throw new MalformedJidException($jid);
        }
        if (!empty($resource)){
            $jid .= '/' . $resource;
        }
        return $jid;
    }

    public static function parseJid($jid)
    {
        $any_char = '[' 
            . '\x20-\xD7FF'
            . '\xE000-\xFFFD'
        . ']';

        $conforming_char = '[' 
            . '\x21'
            . '\x23-\x25'
            . '\x28-\x2E'
            . '\x30-\x39'
            . '\x3B'
            . '\x3D'
            . '\x3F'
            . '\x41-\x7E'
            . '\x80-\xD7FF'
            . '\xE000-\xFFFD'
        . ']';

        $hname = '[0-9a-zA-Z](?:[0-9a-zA-Z-])*[0-9a-zA-Z]';
        $domain = "$hname(?:\.$hname)+";
        $resource = "{$any_char}{$any_char}*";
        $node = "{$conforming_char}{$conforming_char}*";
        $regex = "/^(?:(?<node>{$node})@)?(?<domain>{$domain})(?:\/(?<resource>{$resource}))?\$/";
        $result = false;

        if (preg_match($regex, $jid, $match)) {
            $result = array();
            $result['node'] = empty($match['node']) ? null : $match['node'];
            $result['domain'] = empty($match['domain']) ? null : $match['domain'];
            $result['resource'] = empty($match['resource']) ? null : $match['resource'];
        }

        return $result;
    }
}
