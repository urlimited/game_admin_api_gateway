<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Setting\Data\Repositories\SettingRepository;
use App\Ship\Criterias\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use CodeBaseTeam\DataStructures\Tree\TreeBuilder;
use CodeBaseTeam\DataStructures\Tree\TreeNode;
use Illuminate\Support\Collection;

class SettingHideMetaDataTask extends Task
{
    public function __construct(
        protected SettingRepository $repository
    )
    {
    }

    public function run(string $schema): string
    {
        $parsedSchema = json_decode($schema, true);

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

                            $node->$childKey = $child->$childKey ?? '';
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

        return json_encode($tree->getRoot());
    }
}
