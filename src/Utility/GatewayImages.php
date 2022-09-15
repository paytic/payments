<?php

namespace Paytic\Payments\Utility;

/**
 * Class GatewayImages
 * @package Paytic\Payments\Utility
 */
class GatewayImages
{

    /**
     * @param $gatewayName
     * @param null $default
     * @return string|null
     */
    public static function logo($gatewayName, $default = null)
    {
        return static::asset('logo', $gatewayName, $default);
    }

    /**
     * @param $gatewayName
     * @param null $default
     * @return string|null
     */
    public static function band($gatewayName, $default = null)
    {
        return static::asset('band', $gatewayName, $default);
    }

    /**
     * @param $type
     * @param $gatewayName
     * @param null $default
     * @return string|null
     */
    public static function asset($type, $gatewayName, $default = null)
    {
        if (isset(static::$data[$gatewayName][$type]) && !empty(static::$data[$gatewayName][$type])) {
            return static::$data[$gatewayName][$type];
        }

        if (!empty($default)) {
            return $default;
        }

        if (isset(static::$data['default'][$type]) && !empty(static::$data['default'][$type])) {
            return static::$data['default'][$type];
        }
        return null;
    }

    protected static $data = [
        'euplatesc' => [
            'band' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZ0AAAAeCAMAAADAUjNSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAxBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MTgwRUZBNEM5NUI5MTFFQTlCMkFFODlBQkI5NTMwNjAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MTgwRUZBNEI5NUI5MTFFQTlCMkFFODlBQkI5NTMwNjAiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiBXaW5kb3dzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9IkI2RjM5OUE1MDRCOTIwQjc3RkNEMUVBOTJFNjY2NUVCIiBzdFJlZjpkb2N1bWVudElEPSJCNkYzOTlBNTA0QjkyMEI3N0ZDRDFFQTkyRTY2NjVFQiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Ppx0yXAAAAGAUExURf7+/rKyrQALlWCeC/6VAdvYxE5dr8oBAQNj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',
            'logo' => '',
        ],
        'mobilpay' => [
            'band' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASMAAAAeCAMAAABQbYjYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjA1ODJEMTU5NUJCMTFFQTk1MkZBQjIwMDY2NzE2NEMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjA1ODJEMTY5NUJCMTFFQTk1MkZBQjIwMDY2NzE2NEMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCMDU4MkQxMzk1QkIxMUVBOTUyRkFCMjAwNjY3MTY0QyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCMDU4MkQxNDk1QkIxMUVBOTUyRkFCMjAwNjY3MTY0QyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Piuw+PMAAAGAUExURaq4z/6mCWhkYPdnam6JsQgGBvz8/OTs9tjl7wsUbPlTDyeUydjd6AAkcv74y7TP6Pizs/vR0vkAAipruP3cjbWxtL6/1+Xn7XZ4qgEzffvpupVNaKKt5viDh/m7SYGQuPrKbYF+gJubwLxxglJ0o+WWAvvg4JutxilUj2my2N3//9nY2B5KiBmLxfHz9fuzJv6dAfvz4Lvc7fkyNbPF3FKHweONAPjfr/g6CYMQJxer5UxPkB9jtUJrnlCn0yqg1sbExoqhwZHI42mVzvvt7vfBw/P2+YGp1yomJxJasKvp/MfQ3wACXLQ1SGXK7zQ8fjyMvR4gdvf6/M7a/5W33JGkwO7v9PYWHfv29+eVHEV9wpqn42RmoPZLTI6w2qawzJl2Pc2MJElHSNDf8MIpOPednpig1vWBMjpflf377dcbJfmJCNDR4fYIDvdqFf0QC6TA4Z+dnjd0vOEUG72FLPomHvSrdO4EBr0BBf4ACv+pFAk7gP4AADOZzP///////6d4cocAAACAdFJOU/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8AOAVLZwAAC7VJREFUeNq8mQlfGlcXhxHwwgiE3REMjFiKNBAEhRej4MoiZaw6jUithARDixWM0pomome++nsuiywzsaSt/f+GWa4S4cnZr0J8SgGkTel02pSCgbWIkyoC0l/Xz3Dz44qbYdvv0ai3FsYXxwlDn09j3N7eNi4NLBbNVRfKlOovKZ6SUEp1/PmzxWL5bFk2FTtL57bF24lwODxx646T0Tcoyuz0uGK5evs97BZ8jbYy/T+nMa7fd/Wdto0JfKrju44+l8zk6RkVSxb6t1B4sRxX0XDO5yYoHiq8ubWN2NJ0YZo5HFP66S4jBRscVw7vACOyff/ypa6DSKfTrWtF0ae6G9SNGZ6WEZgsHUBd3VmWi89uu4Buu5gWI8OM2GmeGU98n5HeYHB0ZaC3BiqHgWEMvZWemGSfkWa9B6iH6Xvfh7sRVeEpGUHVMkiIynJ8MUiIKnwbGWU0phkxfUZah6PVVc0fbDlatVbQ73Akk3jrCPpbfRn6dpS5f3k/rNXZO6lcT8lIiujzytTl7ajCE5G/xYiRZeTwZliHI6QPsvlgHoANMl4Ar0GGkRTRxsbs3p4UUvXpGPmkiD5MTa1MLUogLZIRX/sHduQw6MGgBm8N1GpQ+7foM3AyjOA7KaKD+9WN91JI5kcYgT7AdkIW0QcywAZYMaOhKgjwl4jIsQTR55VLhCRjSXMwELMV/Liqy/maIQq1jJ5fAL8X9EGGQVKFBRlGS6OI7uXwtLUMX2ZUqEwqO5+e3Z28ZvFJeN2MxWInsVg2I8tFIJhbu54mRXSDViRnSBMT531Gev3aaVszqM6VHvjies8znV84LZTlGB1BHmqGTMbAcIA3pO4gUSkjcq8bRXSPnra3NytDKv0Io8nJSucbByYnPaHdyUomm2taE4mENXdCZN7AKq9R7Z+QGxkzmqKSM6R+BTCd75Ux9ULnSkjnWqizo5XOvBwjNUCUr8FCq8ajDXkhpAUZRm0z0tHMr3tI/xurVAcyhkS+zGi3x4iwAaCMhKz1BK3opHmSMMrZkSeAxtZmZO4URgO5/+7mss1o6nLxNjxaABAJI1I+ZPaRygxfLvP7UFhD5zqsA5QZZuZRRhijk3wZampgQyF1prBVBv3Qjykj2G672vr6uq590uk27n/vALHgJ7+5GYaUUgSu7Rn9tZ2IoWt7gX7Vut1u3ySUkRI2rwNEJIFNodhhZL0iQiZmTWQBi1Sj8YyI2qgRv6ImGs2QTdbu2YSuqzUw1zcaHUz01GM0dTGx6KYehq+eIUWkdoR0GD3U+UNhjZ+BfX5tegYZkUOeX3uMkcN/pDY41Fst/1E96vcrkjyj5lqjjNqu9hLr8+1cFNrh++XB3nvqa+/3frvbe1HtwumWSyaFZ3JXuTs5qQzgabcuFit4xSVqOUol3iqBnZy87toRNSB4k7C+gTfodtZmDIyJxJkI2YRVK4LYjUdQsrhI1eLCMhJ1h62IJf1xhcbsqZWVn54BONGSwhMTYdqUOG0XNhlG8/whi2zyLM/r8zyaBqDXcfwhf/oYo5aDQc8yMPTKGPDAG0ZSH2kR0UZiHhk1ixBa1wIYdavfkxc/rP7wAqqzApSqprSrVATfMmWkoowmd+mBJ/QuDwKimDYJZVXBVyCEjNgBRjvWxFUhlzu5ylpz0ZA191oUThInA21hatliBlMjBVVVyudquARfKZUqmYTqn9V41QQ295zt/HxuMR6fm4vYiO1iTp4RKSMQDl1NwTP7ehqU+LXTx+2oCwoX9pVv3/7x7t27P/54K7GjJRp+EpshyB6dp7TJMrcJ3xmBq2uycJbd+wbMs2egrQNbFtqVdwkZTV4LdiQT0iMHzF+7m8S+O+lBRrsBiswe2n1g1NwxGt80m4krotVqEE0uS3ZyMcg0EzsDBUGx8dlcNLlSgmvZZRJMUF0upVzmtKqo8rGujA2NZ84WITZwxkk8Au6wPKP9+iGvB+pqcMrzzDT1v/r8XzNyOILKt+9+6gh9emJfllGzOK2vs4ri0sttYx6OCuSKLXDwwvNpE37fA9OrJVh+tQClHqOAuImgRFKZrGDY3e3Eokw7Zus7ftZjdELzGnqZRjy7ymaNMUQTzZ0IWrSswWbWcpOq+vBQqUzpoov4GqrIr8RsSpmEXy+RSfg27oxE4pGw89nFHCzKMsJQvcZzUGd4BY1ODH8IGjQp7q8YOVqVt2/fKpX7HXNCe1JKfG2JhqMYHEVBqwYMqlv6EAf5smI7WGPhm2mf5Rui+vQidfcpCss9RpuUkV1Ey6GMKh1GQptRoONnD4yaVCd58SyXoA/WHdBYrVpjwqoZYJQ6LhVVkFKZ06RUhcaf5lTaVEJruqnCyiXYwhNOWHQ6487weTzsPL+VZaRgDvl9QiNQhj5yPENm2v3ufuZRRhWlstLqdLBdt3PIxqOXHMQUkFXDPCwdEE2N5A9i6z80OVjQ+n63w82r70HlAnMvHvUYCchHj3bEihi/PZjJ0KLsw3ZkfaM5O6OjFozbZ6KGuhg5SVy9yQ2GIxH/dXMJXKpUFUwZs8mUSiMsV6HqSqdWVmwEnE4Sh3gkjpVRhMTd7rgcI57h0b2oq83M1Oun/KmeP+S4U35fkGPUZuFgHMFKsAdlJEgN57WNxDVY20fNDmxKG6QlxVEeBPPsNsy/hg+f1l68EAI3vbz2wAg5FPGx4sFQbacxu+Kh0TvzELMTD4XR61zzSrhCRkTMJmInQ+EIc/+y6th1U1I1XFVVSWVyNZarpZWPzo8fMbtdzMXdi3Hb3NycO3xrs825Fxcjsr5GM1idR1CHtPXYxxppvo2O/ZIdYeKvDaY4x5cY0XSvSx50D3/swHq/4a95Y82k9+C95dXeb1gB3H16Nbv3Zzv3+xRKyoiai0gtJ1Og6QzpEMxmFZrWKkWsuD2Y/2mdneuFHTQhzGzNXIyIVzlrcygcobP1asi+Pkyt3KygLmkJSXM+rSTbA8nwokydDZqff9YA6H95LoDwnOOeg/DLc0KXn8v5mmELC/IjbGUN7eRPp0atvJdpX+mLngzDdfaG7uHQbeh6g5E/Lb1KcrDOrns8BZG99rAisXuwlCxcezweuyCSa08g5FFeZ7C49ATwyQ7a6JXmYRD8OmvMnF2dgSic7WBIGu6HS5JepFtor1xKO/94v1+rn8e7cj575uye8UQv/YW2yC+DjMrYePiToOaDR2qHoaXewodo0J9Meg3JI6+hlaypvY4HRoK0X4vNtvWbtBcxYb/Wrvu6xV9nTk+I2F2C/vposw8PHQTsJJojXW7aItPTdlsRyXBkoO//0fm/cfXs+SCjBeDUiMUbzORZtQG7FvUCBnrs3speGvFbBEtQr+Gxvn+VNmwbUkY38C/Mj85i1lx2hCCo5GcjUxcyZjTM6NuxJGWUP1PXwLsACjbPURzoePwCqFuhKLMASVD4geszgnXJ/OgAO7ZG4+vmR2NrJ2c9CUnm/dIBUmNF1tPmnH1I4zP69tthRtjGthxe8CrQeGpbfUYtQyaKjUwSOMcgIzGkk0A6lfU0178yh9ReaYXxBpErF9LBiBvgXPznjBaoR9XoBLKuTzoKQA0I1Bz4GTWEgAvCVmuIkViQQFpdPbVIEcFT7ov4GiOQ7iwl98Tw0H8i7B6aRP1tRg6/16v2B71BQ22BCxqC3FHN4N3y+72Y4rwLGK29fjwcA4zEjHRfxPwf74u0O9sBSphQq0Dcg7Mj7PtHNtimf4z/jZitZ7DJxxKKYXjGQK/0id7hAqb89kr3qA3srwnb9w+U6P7aGf6/lobDdfqJ99foDttx33gtJbpRC043LYmo8OIe3c/G3G8bV+e93F/OqMeVtzy0T6vdfrCi9aXuPm3pQ59Q8T/YyxZJWrV83Gg0jksuH/R2+7GyRiNadNukO/7TXPn5uFqY0XcYqfP68RX1DlUpRLNNtZR5cHmSMrtUKpWrmiL/yX5/u8iClK/4sBfQrb8ikfOhpYcPWPgadb5EJpr/CkX18PVf4v8CDAD2b9xFKu7CkwAAAABJRU5ErkJggg==',
            'logo' => '',
        ],
        'payu' => [
            'band' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAVcAAAAeCAMAAACvz606AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mjc0NTQ4QkY5NUJDMTFFQUEwQzVCMkZBNjQzRDM0MzYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mjc0NTQ4QzA5NUJDMTFFQUEwQzVCMkZBNjQzRDM0MzYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoyNzQ1NDhCRDk1QkMxMUVBQTBDNUIyRkE2NDNEMzQzNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoyNzQ1NDhCRTk1QkMxMUVBQTBDNUIyRkE2NDNEMzQzNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pgo4z1EAAAGAUExURZUHKKG0zaOj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',
            'logo' => '',
        ],
        'default' => [
            'band' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK4AAAAZCAMAAACfHeURAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3NpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDoxN2NkYzM0ZS1lNzdhLTQyMDQtYmZiZS1lYzE3YjkzNDgxNzYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MDRGOTFERDI5NUJDMTFFQUJBRDI4MzBGQkZGOTkwMzAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDRGOTFERDE5NUJDMTFFQUJBRDI4MzBGQkZGOTkwMzAiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NGNhMTRjYmYtYzQyOC00NTk3LWFjMzYtNTE4MDc2YjNlZDBlIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjE3Y2RjMzRlLWU3N2EtNDIwNC1iZmJlLWVjMTdiOTM0ODE3NiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PpWMgH8AAAGAUExURfQYMfi2TWGjyf7+8v385wIQa9bo9QaY0un+/cxhevP+/upRZ+s5TPArN2mIvAsqf///+SlQksfW8aq20/uzNvj//1JyqszR1Pjny/PFa5aqy//5/v3apvnLhvz0/oGPsLzF0NO70wuh1LTJ6QKj551lgimErgGd3//+/+dTHnfI5vF2hv6rLfSxFquts/rp+vylPRY+jFRll/j/+PyyJfq1u/fSzfX+8sq0uuPw+X1MXsDw/2x6qv7r5ZOft/717f/8/y9ZopKx5fPz8v3b4YmKm5rZ8//59UJnqUBWjubk6bG84tcnQPj5/vv///GLB+72/v7+/OX470W13qeGjlh+upzCzDFBf/j599fe3iip3H2ZyauUpcI3VveUndjEp9eIkDiZvfuEQoyOI8mfq2hsn0hZpOgZI828iOceMPz8/++5Of/trhZHoPz/+vz8+t3Tmv/8+kNlkJJ8b7e8tO0LJ/GrK98gJTMlNxKFxr+QINmxSaI2S35fKKF8LP///2/8Mo8AAAuISURBVHja1FcLQ9pKFsaGAA5CBnFQiUYrPqZqVYw2pT6Ioo0imRK9FCj10a7WS6zhxvq43XZ3/vqeAeV27/6CPWCGKMI333znnO8EGNItTKjKKKUOxoaue9z0sc44x5wz4uo6oZbETAjKHV2ltNVyPF08DI8xyl2bc8/h8MKFy1MwckhM3zEkBxuea5oS1onnSVijjq4brMUIIYz7voEtC2NqEuaqJiWI6C1uauIF9x1YVJWLdz5+cIBQs+ZQFvE8y5IgNI0hYmuq3w6HqlTXqUnhL57nMsZanLfacBzHgcV22h+Dcee3rS5cyWZYNTWOW2IjtEVFuKZYYY/U5A5jLsUY+wIkoyqEDwgIV1WCvLxLuefpjEWIZZmw+Ue4TFMpa2E9uDrX12zG+s5WNZvg4NDocM/V1fDoyAbgJaZpYYEOvstj8PWAHwLQUCAcY8c0VbHCqy7ccnXssJDP5+1CQasV4KJpcLELNXiIlxB2wXYkH76eMGbrCEUQnDLiEvY1N8KYL9iTLMuDDdTQI1xVM6nu5Vf7YgGIZjNQ6l0Nfh1eGlgRMTAwPAInQwCbODNJwkCwC2fboctu1WgbuglseRB/wUVKBRGEbMKpWsNMl2wK/17jus5NE2ikjg8n50gWkA0UU5+svT2aCIc/HM2GTI7z1quzaKkZiEVPXlkYhPgI1+Q20jdOSg8PD81m8/IyELjs+9wzAEAHluBn4L5nJA/8EjhvCXsgViFQ+C6Ma5QL/Bi3BGTnMZ7gBrNxpOq65pgu9kCoOnFrQQk2QFzN8hmyecHSVKZjRnA+7/O12U/hmUmImfDE0Zo5FO1rCvoAVOlsx+PaI1xEC8Q6Kd0FOgH0BmKflwZersxDANyVl1cCry70DlhtgOZCTnHsFDivGYDX4czDksdsOFLmdVNNiQdHhoeHv6qq0T+2iTKNA0JyybH4WEgzSTKdRAwXTIBLGM776O2HMKCdmZmcEOvRx1ip+XApyAvcBZrRVf9JDADDPOm7ayMVWJuXfbEXL+6vgN6eHkALeHtGVG7YjEvBoAWS8CFZbFJjZUBnSKRMiE10QxciYUzvajcr4P7z3Y+8ebgvLxcS8jrK7MsQyTJLKrKSIbhAOaGEqQLtjIhwOCwgT05PlQSgy0tABJju+lYfPzfgRNBO9C52+dBsdsh9+Ly09G4JhNDRLoj45fCG6pr+hiBreCgoOfb42PpgbnN30yakf+zi4iJZJp49vrs7bnfZlUAMGO3+6+WGWVeUDM8qyci+XNneXq+zckq5Vg6QXlBtZrpMpWsCbVgAnpwR9MJNqdQGFGjGHi4Dd8c7T2IwpRP4/UOp+SiHWCwG/PYA1JWV+5WBpfsfVysjNKiqUC3u3717t6MiSZHlwZwsV3UUF3zJCgpKGbFSq5tr2biFy0nlH1+DcXkfhZRsCClKnKsWZv1K4kYZYwWNg6rNII0cTcyEJyfDbciTk9+nmkDrZQyed4LcS8Ac9UyoejSgqlL0+CTaOxdtBu5izRIId35+6Wrpx+vT4Z6XA0sA+8foKPItSi118du/X44GPUBWVdOyvM43ZTl7sVxddiXjQlYUpR//ol2Lk9D1n0NGQmnYSSUbOdxXsnuDJEji8nZSThFf4wbjTAJywwAXeJ0MtzFPgHyn3wCzd7EHUDBcAoFXpitJbsDXzL5v2vnz4NkJgD7vNU56T+aO536r1xdOT0cA6e+ntzs9iJiUIYQu5H8OB0kFBEjXZXnbBjEeuBYtmmpIoJWTXbhcieMWQSk52Q/Eug15qyz1b8F7tkkuq0SYksjhIpaISSR3FjBOHB1BEfsgsI79PC4dH4N652IBOPTLdv7POW12JdVqbhZuQ3Rqd/C5tjDFfytsLn5UN2vD99/Sg6e1eu409OrKZQaxqWFk5D9/WKGsrOhkWZb77aqs7PdDc/LVhpxtZOWG8YTWycYdl+kNZS8lx2tGSkmRDVVLA8HovbwVGr9WMp7mSASkRT+AZJ9F0PRa5O3R0dHkdONZfPpTem4qP9cXi5ai0T5RXTHUSoBLaGB8XHtuny8enu/kflvcRcXCwvOxoZ6B05DxuvWx8GPwj/ugGuSaFDTLVfkN3ZblMamVVZQcTssg44scM7giL8Mfv3TZ9bJxTN0gyBSABSN78hgqqjwSV6qRG/hXyLU00swawNX9iZnJcLKQj5el2bf10Nt0uZ57ptVff7Rf161icaO4EW2WAhL1PBrABB0XN7304OLH4tnUYbL47bD37Pbsm/HHgnR7eFvfNX5fHO2RREcPSgzUoIRSslxXQ4qcMDBPA1y5GkKg5AMgXDF/STXoeEGUUJS9SDB3LWci1S/xyrWczijZyt7ylrxObGjAJtHViZmZ7/WM0f8eP3s/izLl+jh9VhvvXRj8ufh8t9b7Bs1B9ZXaYmCqMXU+df7t4+74wmZy4eJ579jt5uu+s93MwsJtcvOPbwu3g8Oj4Iwg11wCsJT1rLzMnANZXtZ9zMpjINlNAqo4yMBe+n9hVwIfRlKKkvasjCKHylnYWnY9sizfgDtIy9UIV6HlcK8NlzT0SNrfDlVy2+j9p2ffK6HnxfM3rHd3sXeqNgcFywBTxaAyGCexdjGG0gt17CG2JGL+/n5gfuXqfn7g6up+4GtN4tAawMfVZThJ+QAZQGcc2qknQTbJ6RwkGugiK6ef4FIF4KqSmxvvh7JSfNtf8EOZ5EFR1cczRTisSCZjFMAKIN9RP0zOTNuf7PfpYhrVybP3wVB9LRT5WNTOg31vcot0PNp86OPM91m3TTS7bSL2Ivbic7dNDAzMzw8PUfIEIwGoqshSRXVAy18a6XhWlnNj7boAz8oTWjUbZxIYQuE5Gat52Kt5wlEAnbjGW66pqvqhYyOCJTQ7MfMdIvz9e2eZFrFc+vnm58+75s83x4FYs3mWB2PWbsLqaumvJiwczufP80t/NWFhcrxuxkP9khsEq1XoFETuxGYIOkR/f6g/K1dtYXkhh+1sBXG31ra2rRbIDgx2AfQE7t4HvBTnwUDnVTAfebo2EW43YChiYUi7T9DQSqXAw2W7a9012x3slY8oRV2Lc/locWAFywDE/mpxsN71AgfV/f0Q4dqX6nKOX+xXleryAUpXq5vEkNT16pd6sdZ5Y3UrGcqVI+VyGeXgGQrlIEIicqFcvXNHfRXMpHs4224PkzMdizMhmtvNMSi0FGhbROAxmvcilEb+20CCB4rd3fWd9Fy9HHh0kG1uSRctd2wXDEKNorKGsWuXc7ZLWMFVVU2C1NLMArBLWzALJbLVxFaiE/uJRGpvv5ra/1JJpVI3N9VKKrFf3dsnMDW1uM9EW+t4hnZT+3RceogFhMERnrYZEx6nIIYE8j/2/C7Wu5ofGu55suejI3loZ7RboPLY5TXHsYMYDJrDwUFKULDyQThmGC6koNCtGKycretsFp7Z9qJsbVduEtupyl6iUYk3KpVUPJ7ayiJQMatJPhGOTJA7AY1YWN7pY0h+SH3BYOwS0HoFmMNU+jT8kPbwEyj1za3mdcT+NvzALNF1WsKPw3nDPCFJLWo6IERbdcC2eg44S73j0Fs1KXGdSFxn4QprNvupsZfaA7hKIp7INBrV1Pb29laVSDBSMmyZHQcpAAPiiZkPm7FAJ5HaCo2eQjOjkJzmL6NlzRLTkebgVoGiiBgsLTFbcoJaDnWf4OIaNoFrCXbJxYYBGVh1GAfFpOaCK34Mv4P1CW4lngJalxup/dRN4wZep9bjiQSSVKLCZOybREwTgtjJsJgmrKEoGLIH4cyapbkdyyEwnsP4Fvj74G7oBKZEnz4N7nAPRyx1C5kgVjVhEJJgDzD8tFxqQ6LDeAWbAxk8je7m3paIBOi3/diD+73EXkrcwN3Wtbgig9qqhZCVD1ru2uwRaGFCzGowZRivTqKgz1L0ZAcmQ5ieOGiSBfj/VfxHgAEAb637kER7VEoAAAAASUVORK5CYII=',
            'logo' => '',
        ]
    ];
}
