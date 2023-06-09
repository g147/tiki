<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * "Side-by-Side" diff renderer.
 *
 * This class renders the diff in "side-by-side" format, like Wikipedia.
 *
 * @package Text_Diff
 */
class Text_Diff_Renderer_sidebyside extends Tiki_Text_Diff_Renderer
{
    public function __construct($context_lines = 4, $words = 1)
    {
        $this->_leading_context_lines = $context_lines;
        $this->_trailing_context_lines = $context_lines;
        $this->_words = $words;
    }

    protected function _startDiff()
    {
        ob_start();
        //echo '<table class="table-bordered diff">';
    }

    protected function _endDiff()
    {
        $val = ob_get_contents();
        ob_end_clean();
        return $val;
    }

    protected function _blockHeader($xbeg, $xlen, $ybeg, $ylen)
    {
        return "$xbeg,$xlen,$ybeg,$ylen";
    }

    protected function _startBlock($header)
    {
        $h = explode(",", $header);
        echo '<tr class="diffheader"><td colspan="2">';
        if ($h[1] == 1) {
            echo tra('Line:') . "&nbsp;" . $h[0];
        } else {
            $h[1] = $h[0] + $h[1] - 1;
            echo tra('Lines:') . "&nbsp;" . $h[0] . '-' . $h[1];
        }
        echo '</td><td colspan="2">';
        if ($h[3] == 1) {
            echo tra('Line:') . "&nbsp;" . $h[2];
        } else {
            $h[3] = $h[2] + $h[3] - 1;
            echo tra('Lines:') . "&nbsp;" . $h[2] . '-' . $h[3];
        }

        echo '</td></tr>';
    }

    protected function _endBlock()
    {
    }

    protected function _lines($lines, $prefix = '', $suffix = '', $type = '')
    {
        // MODIFIED BY THE TIKI PROJECT
        if ($type == 'context') {
            foreach ($lines as $line) {
                if (! empty($line)) {
                    echo "<tr class='diffbody'><td>&nbsp;</td><td>" . htmlspecialchars($line) . "</td><td>&nbsp;</td><td>" . htmlspecialchars($line) . "</td></tr>\n";
                }
            }
        } elseif ($type == 'added') {
            foreach ($lines as $line) {
                if (! empty($line)) {
                    echo "<tr><td colspan='2'>&nbsp;</td><td class='diffadded'>$prefix</td><td class='diffadded'>" . htmlspecialchars($line) . "</td></tr>\n";
                }
            }
        } elseif ($type == 'deleted') {
            foreach ($lines as $line) {
                if (! empty($line)) {
                    echo "<tr><td class='diffdeleted'>$prefix</td><td class='diffdeleted'>" . htmlspecialchars($line) . "</td><td colspan='2'>&nbsp;</td></tr>\n";
                }
            }
        } elseif ($type == 'change-deleted') {
            echo '<tr><td class="diffdeleted">' . $prefix . '</td><td class="diffdeleted">' . implode("<br />", $lines) . "</td>\n";
        } elseif ($type == 'change-added') {
            echo '<td class="diffadded">' . $prefix . '</td><td class="diffadded">' . implode("<br />", $lines) . "</td></tr>\n";
        }
    }

    protected function _context($lines)
    {
        $this->_lines($lines, '', '', 'context');
    }

    protected function _added($lines, $changemode = false)
    {
        if ($changemode) {
            $this->_lines($lines, '+', '', 'change-added');
        } else {
            $this->_lines($lines, '+', '', 'added');
        }
    }

    protected function _deleted($lines, $changemode = false)
    {
        if ($changemode) {
            $this->_lines($lines, '-', '', 'change-deleted');
        } else {
            $this->_lines($lines, '-', '', 'deleted');
        }
    }

    protected function _changed($orig, $final)
    {
        $lines = diffChar($orig, $final, $this->_words);
        $this->_deleted([$lines[0]], true);
        $this->_added([$lines[1]], true);
/* switch with these lines for no character diff
        $this->_deleted($orig, TRUE);
        $this->_added($final, TRUE);
*/
    }
}
