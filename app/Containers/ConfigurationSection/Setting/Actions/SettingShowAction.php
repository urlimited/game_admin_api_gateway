<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Actions\Action;
use CodeBaseTeam\DataStructures\Tree\TreeBuilder;
use CodeBaseTeam\DataStructures\Tree\TreeNode;


class SettingShowAction extends Action
{
    public function run(Setting $setting): Setting
    {
        $parsedSchema = json_decode($setting->getAttribute('schema'), true);

        TreeBuilder::setValueContentFieldKey('content');
        TreeBuilder::setMetaFieldKeys(['meta']);

        $tree = TreeBuilder::fromArray(
            [
                'content' => $parsedSchema,
            ]
        );

        $tree->traversalPostOrder(
            node: $tree->getRoot(),
            // Removed $node type, since due to processing here we can see int, bool, string and other types
            // instead of TreeNode
            callback: function ($node) {
                if ($node->parent === null) {
                    $nodeKey = 'root';
                } else {
                    $nodeKey = $node->key ?? '*';
                }

                if (!empty($node->children)) {
                    foreach ($node->children as $child) {
                        // if it is not array
                        if (
                            $child instanceof TreeNode
                            && !is_null($child->key)
                        ) {
                            $childKey = $child->key;

                            $node->$childKey = $child->$childKey;
                        } // If it is an array
                        else {
                            if ($nodeKey === '*') {
                                // We can't use array_search for Objects and ints, and strings mixed array types
                                // therefore we emulate it
                                // One more point that PostOrder guarantee that we will not enter into int or string
                                // in order to find specific child's index across its children
                                // Also it guarantee that it will always search TreeNode only (not int or string)
                                $currentItemIndex = -1;

                                foreach ($node->parent->children as $pKey => $pValue) {
                                    if (
                                        $pValue instanceof TreeNode
                                        && $pValue === $node
                                    ) {
                                        $currentItemIndex = $pKey;
                                    }
                                }

                                if ($currentItemIndex === -1) {
                                    continue;
                                }

                                $node->parent->children[$currentItemIndex] = $node->children;
                            } else {
                                $node->$nodeKey = $node->children;
                            }
                        }
                    }
                }

                if (!empty($node->value)) {
                    if ($nodeKey !== '*') {
                        $node->$nodeKey = $node->value;
                    } else {
                        // We can't use array_search for Objects and ints, and strings mixed array types
                        // therefore we emulate it
                        $currentItemIndex = -1;

                        foreach ($node->parent->children as $pKey => $pValue) {
                            if (
                                $pValue instanceof TreeNode
                                && $pValue === $node
                            ) {
                                $currentItemIndex = $pKey;
                            }
                        }

                        if ($currentItemIndex === -1) {
                            return;
                        }

                        $node->parent->children[$currentItemIndex] = $node->value;
                    }
                }

                unset($node->tree);
                unset($node->meta);
                unset($node->value);
            }
        );

        $tree->traversalPostOrder(
            node: $tree->getRoot(),
            // Removed $node type, since due to processing here we can see int, bool, string and other types
            // instead of TreeNode
            callback: function ($node) {
                unset($node->children);
                unset($node->key);
                unset($node->parent);
                unset($node->id);
            }
        );

        $setting->setAttribute('schema', json_encode($tree->getRoot()));

        return $setting;
    }
}
