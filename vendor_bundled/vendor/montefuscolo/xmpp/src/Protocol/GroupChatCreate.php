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
 * XEP 045 - GroupChat
 *
 * @package Xmpp\Protocol
 */
class GroupChatCreate implements ProtocolImplementationInterface
{
    /**
     * GroupChatCreate constructor
     *
     * @param string $ownerJid The room owner and creator
     * @param string $roomJid The room JID
     */
    public function __construct($ownerJid, $roomJid)
    {
        $this->setOwner($ownerJid);
        $this->setRoom($roomJid);
    }

    /**
     * {@inheritDoc}
     *
     * @return string xml representation
     */
    public function toString()
    {
        $invitation = XML::quoteMessage(
            '<presence from="%s" to="%s">'
            .   '<x xmlns="http://jabber.org/protocol/muc"/>'
            . '</presence>',
            $this->getOwner(),
            $this->getRoom()
        );
        return $invitation;
    }

    /**
     * Get room creator.
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set room creator.
     *
     * @param string $owner creator jid
     * 
     * @return $this  GroupChat object
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get message receiver.
     *
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set message receiver.
     *
     * @param string $room the room jid to be created
     * 
     * @return $this GroupChat object
     */
    public function setRoom($room)
    {
        $this->room = (string) $room;
        return $this;
    }

}