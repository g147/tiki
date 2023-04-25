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
 * @author  Fabio Montefuscolo <fabio.montefuscolo@gmail.com>
 * @license https://spdx.org/licenses/0BSD.html BSD
 * @link    http://github.com/fabiomontefuscolo/xmpp
 */

namespace Fabiang\Xmpp\Protocol;
use Fabiang\Xmpp\Util\XML;

/**
 * XEP 045 - GroupChatConfig
 *
 * @package Xmpp\Protocol
 */
class GroupChatConfig implements ProtocolImplementationInterface
{
    private $_attrs = [
        'allowinvites' => null,
        'allowpm' => null,
        'changesubject' => null,
        'enablelogging' => null,
        'maxusers' => null,
        'membersonly' => null,
        'moderatedroom' => null,
        'passwordprotectedroom' => null,
        'persistentroom' => null,
        'publicroom' => null,
        'roomadmins' => null,
        'roomdesc' => null,
        'roomname' => null,
        'roomsecret' => null,
        'whois' => null,
    ];

    private $_from;
    private $_room;

    /**
     * Constructor
     *
     * @param array $from   the user setting configuration
     * @param array $room   the room to be configured
     * @param array $config config as key/value array
     */
    public function __construct($from, $room, $config = [])
    {
        $this->setFrom($from);
        $this->setRoom($room);
        $this->loadConfig($config);
    }

    /**
     * Room Configuration XML representation
     *
     * @return void
     */
    public function toString()
    {
        $output = XML::quoteMessage(
            '<iq from="%s" id="%s" to="%s" type="set">'
            .     '<query xmlns="http://jabber.org/protocol/muc#owner">'
            .         '<x xmlns="jabber:x:data" type="submit">'
            .             '<field var="FORM_TYPE">'
            .                 '<value>http://jabber.org/protocol/muc#roomconfig</value>'
            .             '</field>'
            .             $this->_getConfigFieldsXML()
            .         '</x>'
            .     '</query>'
            . '</iq>',
            $this->getFrom(),
            XML::generateId(),
            $this->getRoom()
        );
        return $output;
    }

    /**
     * Set the user configuring the room
     *
     * @param string $from the user jid
     *
     * @return void
     */
    public function setFrom($from)
    {
        $this->_from = $from;
    }

    /**
     * Get the user configuring the room
     *
     * @return void
     */
    public function getFrom()
    {
        return $this->_from;
    }


    /**
     * Set the room to be configured
     *
     * @param string $room the room to be configured
     *
     * @return void
     */
    public function setRoom($room)
    {
        $this->_room = $room;
    }

    /**
     * Get the room to be configured
     *
     * @return void
     */
    public function getRoom()
    {
        return $this->_room;
    }

    /**
     * Set attribute to XMPP room config
     *
     * @param string $name  attr name
     * @param mixed  $value attr value
     *
     * @return void
     */
    public function setConfig($name, $value)
    {
        if (array_key_exists($name, $this->_attrs)) {
            $this->_attrs[$name] = $value;
            return $this;
        }
        throw new \Error('Attribute not allowed: ' . $name);
    }

    /**
     * Load config from array
     *
     * @param array $arr config as key/value array
     *
     * @return void
     */
    public function loadConfig($arr)
    {
        if (is_array($arr)) {
            foreach ($arr as $config => $value) {
                $this->setConfig($config, $value);
            }
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function _getConfigFieldsXML()
    {
        $xml = '';
        $attrs = array_filter(
            $this->_attrs,
            function ($val) {
                return ! is_null($val);
            }
        );

        foreach ($attrs as $key => $value) {
            $xml .= "<field var='muc#roomconfig_{$key}'>";
            $xml .= '<value>';
            if (is_array($value)) {
                $xml .= implode('</value><value>', $value);
            } else {
                $xml .= $value;
            }
            $xml .= '</value>';
            $xml .= "</field>";
        }
        return $xml;
    }

    /**
     * Whether to Allow Occupants to Invite Others
     *
     * @return int
     */
    public function getAllowinvites()
    {
        if (isset($this->_attrs['allowinvites'])) {
            return $this->_attrs['allowinvites'];
        }
        return 0;
    }

    /**
     * Whether to Allow Occupants to Invite Others
     *
     * @param boolean $allowinvites true to allow
     *
     * @return void
     */
    public function setAllowinvites($allowinvites)
    {
        $this->_attrs['allowinvites'] = $allowinvites ? 1 : 0;
    }

    /**
     * Who Can Send Private Messages?
     *
     * @return string
     */
    public function getAllowpm()
    {
        if (isset($this->_attrs['allowpm'])) {
            return $this->_attrs['allowpm'];
        }
        return null;
    }

    /**
     * Who Can Send Private Messages?
     *
     * @param string $allowpm (anyone|participants|moderators|none)
     *
     * @return void
     */
    public function setAllowpm($allowpm)
    {
        if (in_array($allowpm, ['anyone', 'participants', 'moderators', 'none'])) {
            $this->_attrs['allowpm'] = $allowpm;
        }
    }

    /**
     * Allow Occupants to Change Subject
     *
     * @return int
     */
    public function getChangesubject()
    {
        if (isset($this->_attrs['changesubject'])) {
            return $this->_attrs['changesubject'];
        }
        return false;
    }

    /**
     * Allow Occupants to Change Subject?
     *
     * @param boolean $changesubject true to allow
     * 
     * @return void
     */
    public function setChangesubject($changesubject)
    {
        $this->_attrs['changesubject'] = $changesubject ? 1 : 0;
    }

    /**
     * Enable Public Logging
     *
     * @return int
     */
    public function getEnablelogging()
    {
        if (isset($this->_attrs['enablelogging'])) {
            return $this->_attrs['enablelogging'];
        }
        return false;
    }

    /**
     * Enable Public Logging
     *
     * @param boolean $enablelogging true to enable
     *
     * @return void
     */
    public function setEnablelogging($enablelogging)
    {
        $this->_attrs['enablelogging'] = $enablelogging ? 1 : 0;
    }

    /**
     * Maximum Number of Occupants
     *
     * @return int
     */
    public function getMaxusers()
    {
        if (isset($this->_attrs['maxusers'])) {
            return $this->_attrs['maxusers'];
        }
        return 0;
    }

    /**
     * Maximum Number of Occupants
     *
     * @param int $maxusers number of occupants
     *
     * @return void
     */
    public function setMaxusers($maxusers)
    {
        $this->_attrs['maxusers'] = intval($maxusers, 10);
    }

    /**
     * Is Room Members-Only?
     *
     * @return bool
     */
    public function getMembersonly()
    {
        if (isset($this->_attrs['membersonly'])) {
            return $this->_attrs['membersonly'];
        }
        return 0;
    }

    /**
     * Make Room Members-Only?
     *
     * @param bool $membersonly true for members only
     *
     * @return void
     */
    public function setMembersonly($membersonly)
    {
        $this->_attrs['membersonly'] = $membersonly;
    }

    /**
     * Is Room Moderated?
     *
     * @return int
     */
    public function getModeratedroom()
    {
        if (isset($this->_attrs['moderatedroom'])) {
            return $this->_attrs['moderatedroom'];
        }
        return 0;
    }

    /**
     * Set Room Moderated
     *
     * @param bool $moderatedroom true for moderated
     * 
     * @return int
     */
    public function setModeratedroom($moderatedroom)
    {
        $this->_attrs['moderatedroom'] = $moderatedroom;
    }

    /**
     * Password Required to Enter
     *
     * @return int
     */
    public function getPasswordprotectedroom()
    {
        if (isset($this->_attrs['passwordprotectedroom'])) {
            return $this->_attrs['passwordprotectedroom'];
        }
        return 0;
    }

    /**
     * Set password Required to Enter
     *
     * @param string $passwordprotectedroom true to set password
     *
     * @return void
     */
    public function setPasswordprotectedroom($passwordprotectedroom)
    {
        $this->_attrs['passwordprotectedroom'] = $passwordprotectedroom ? 1 : 0;
    }

    /**
     * Password
     *
     * @param string $password the password
     *
     * @return void
     */
    public function setRoomsecret($password)
    {
        $this->_attrs['roomsecret'] = strval($password);
    }

    /**
     * Is Room Persistent
     *
     * @return int
     */
    public function getPersistentroom()
    {
        if (isset($this->_attrs['persistentroom'])) {
            return $this->_attrs['persistentroom'];
        }
        return 0;
    }

    /**
     * Make Room Persistent
     *
     * @param boolean $persistentroom true to make room persistent
     *
     * @return void
     */
    public function setPersistentroom($persistentroom)
    {
        $this->_attrs['persistentroom'] = $persistentroom ? 1 : 0;
    }

    /**
     * Is Public room
     *
     * @return int
     */
    public function getPublicroom()
    {
        if (isset($this->_attrs['publicroom'])) {
            return $this->_attrs['publicroom'];
        }
        return 0;
    }

    /**
     * Set public room
     *
     * @param boolean $publicroom
     *
     * @return void
     */
    public function setPublicroom($publicroom)
    {
        $this->_attrs['publicroom'] = $publicroom ? 1 : 0;
    }

    /**
     * Get room admins
     *
     * @return array
     */
    public function getRoomadmins()
    {
        if (isset($this->_attrs['roomadmins'])) {
            return $this->_attrs['roomadmins'];
        }
        return [];
    }

    /**
     * Set room admins
     *
     * @param array<string> $roomadmins the admins jid
     *
     * @return void
     */
    public function setRoomadmins($roomadmins)
    {
        if (! is_array($roomadmins)) {
            $roomadmins = func_get_args();
        }
        $this->_attrs['roomadmins'] = $roomadmins;
    }

    /**
     * Get room description
     * 
     * @return string
     */
    public function getRoomdesc()
    {
        if (isset($this->_attrs['roomdesc'])) {
            return $this->_attrs['roomdesc'];
        }
        return '';
    }

    /**
     * Set room description
     *
     * @param string $roomdesc description
     *
     * @return string
     */
    public function setRoomdesc($roomdesc)
    {
        $this->_attrs['roomdesc'] = strval($roomdesc);
    }

    /**
     * Get the room name
     *
     * @return string
     */
    public function getRoomname()
    {
        if (isset($this->_attrs['roomname'])) {
            return $this->_attrs['roomname'];
        }
        return '';
    }

    /**
     * Set the room name
     *
     * @param string $roomname the room name
     *
     * @return void
     */
    public function setRoomname($roomname)
    {
        $this->_attrs['roomname'] = strval($roomname);
    }

    /**
     * Is Room Secret (no listed)?
     *
     * @return int
     */
    public function getRoomsecret()
    {
        if (isset($this->_attrs['roomsecret'])) {
            return $this->_attrs['roomsecret'];
        }
        return 0;
    }

    /**
     * Who May Discover Real JIDs
     *
     * @return string
     */
    public function getWhois()
    {
        if (isset($this->_attrs['whois'])) {
            return $this->_attrs['whois'];
        }
        return '';
    }

    /**
     * Who May Discover Real JIDs
     *
     * @param string $whois (moderators|anyone)
     *
     * @return void
     */
    public function setWhois($whois)
    {
        if (in_array($whois, ['anyone', 'moderators'])) {
            $this->_attrs['whois'] = $whois;
        }
    }

}