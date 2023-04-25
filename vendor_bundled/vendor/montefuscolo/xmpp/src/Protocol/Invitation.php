<?php

/**
 * Copyright 2014 Fabian Grutschus. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice, this
 *   of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *   this of conditions and the following disclaimer in the documentation
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

namespace Fabiang\Xmpp\Protocol;

use Fabiang\Xmpp\Util\XML;

/**
 * Protocol setting for Xmpp.
 *
 * @package Xmpp\Protocol
 */
class Invitation implements ProtocolImplementationInterface
{
    /**
     * The invitation sender
     * @var string
     */
    public $from;

    /**
     * The room jid 
     * @var string
     */
    public $to;

    /**
     * The guest
     * @var array<string>
     */
    public $guest;

    /**
     * Invitation message
     */
    public $message = 'You are being invited to a chatroom.';

    public function __construct($from='', $to='', $guest='')
    {
        $this->setFrom($from)->setTo($to)->setGuest($guest);
    }

    /**
     * {@inheritDoc}
     */
     public function toString()
     {
         $invitation = XML::quoteMessage(
            '<message from="%s" to="%s" id="%s">'
                .    '<x xmlns="http://jabber.org/protocol/muc#user">'
                .        '<invite to="%s">'
                .            '<reason>%s</reason>'
                .        '</invite>'
                .    '</x>'
                .'</message>',
            $this->getFrom(),
            $this->getTo(),
            XML::generateId(),
            $this->getGuest(),
            $this->getMessage()
        );
        return $invitation;
     }


    /**
     * Get invitation sender.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set invitation sender.
     *
     * @param string $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Get message receiver.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set message receiver.
     *
     * @param string $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = (string) $to;
        return $this;
    }

    /**
     * Get guest.
     *
     * @return string
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set guest.
     *
     * @param array $guest 
     * @return $this
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;
        return $this;
    }

    /**
     * Get invitation message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set invitation message.
     *
     * @param string $message 
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}
