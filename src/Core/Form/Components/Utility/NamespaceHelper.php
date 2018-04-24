<?php


namespace src\Core\Form\Components\Utility;


class NamespaceHelper
{
    /**
     * @param $namespaceToSearch
     * @param $namespace
     * @return bool
     */
    public static function getDeterminedNamespaceComparison($namespaceToSearch, $namespace)
    {
        if ($namespaceToSearch == $namespace) {
            return true;
        }

        $explodedToSearchUntilHash = explode('#', $namespaceToSearch);
        $namespaceToCut            = $namespace;
        $restFields                = [];
        foreach ($explodedToSearchUntilHash as $index => $withoutHash) {
            if (false !== stripos($namespaceToCut, $withoutHash)) {
                $strPos = stripos($namespaceToCut, $withoutHash);
                if (isset($explodedToSearchUntilHash[$index + 1])) {
                    $pieceToGetFirstPos   = substr($namespaceToCut, $strPos + strlen($withoutHash));
                    $lookAheadWithoutHash = $explodedToSearchUntilHash[$index + 1];
                    $justCheckLooAheadPos = stripos($pieceToGetFirstPos, $lookAheadWithoutHash);
                    $restFields[]         = substr(
                        $namespaceToCut,
                        $strPos + strlen($withoutHash),
                        $justCheckLooAheadPos
                    );
                    $namespaceToCut       = substr(
                        $namespaceToCut,
                        $strPos + strlen($withoutHash) + $justCheckLooAheadPos
                    );
                } else {
                    $namespaceToCut = str_replace($withoutHash, '', $namespaceToCut);
                }

            }
        }

        if (false === stripos($namespaceToCut, '[') && false === stripos($namespaceToCut, ']')) {
            return true;
        }

        return false;
    }
}