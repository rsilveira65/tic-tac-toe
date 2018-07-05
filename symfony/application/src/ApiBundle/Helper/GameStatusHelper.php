<?php

namespace ApiBundle\Helper;

/**
 * Class GameMoveIndexHelper
 * @author Rafael Silveira <rafael.silveira@possible.com>
 * @package ApiBundle\Helper
 */
class GameStatusHelper
{
    const ONGOING = 0;
    const PLAYER_WON = 1;
    const BOT_WON = 2;
    const DRAW = 3;
}