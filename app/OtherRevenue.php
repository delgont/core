<?php

namespace App;

use Illuminate\Support\Collection;

use App\Models\Accounting\Coa\Revenue;

use App\Models\Accounting\TermlyAccrualRevenue;
use App\Support\Models\Any;


class OtherRevenue
{

    /**
     * Whether to termly or accounting period
     *
     * @var array
     */
    protected $termly = true;

    /**
     * Whether period
     *
     * @var array
     */
    protected $periodically = false;

    /**
     * 
     */
    protected $term;
    protected $period;


    /**
     * Determine wheather termly or per accounting period.
     *
     * @param string $term_id
     * @return  this
     */
    public function termly($term_id = null)
    {
        $this->termly = true;
        $this->term = ($term_id) ? term($term_id) : term();
        return $this;
    }

    public function periodically($period_id = null)
    {
        $this->periodically = true;
        $this->period = ($period) ? period($period_id) : period();
        return $this;
    }


    /**
     * TPopulate revenue
*
     * @return array
     */
    public function populate($account_id = null)
    {
       if(!is_null($account_id)){

        $revenue = $this->getSingleRevenue($account_id);
        $children = $revenue->children->map(function($item, $key){
            return new Any([
                'amount' => $item->incomes->sum('amount')
            ]);
        });
        $amount =  ($revenue->incomes->sum('amount') + $children->sum('amount'));
        ($this->termly) ? TermlyAccrualRevenue::updateOrCreate(['term_id' => $this->term->id, 'account_id' => $revenue->id],['amount' => $amount, 'term_id' => $this->term->id, 'account_id' => $revenue->id]) : 'accrualRevenue';
       }else{
        $revevues = $this->getRevenue();

        foreach ($revevues as $revenue) {

            $children = $revenue->children->map(function($item, $key){
                $levelOneAmount = $item->incomes->sum('amount');
                $levelTwoAmount = $item->children->map(function($item, $key){
                    return new Any([
                        'amount' => $item->incomes->sum('amount')
                    ]);
                })->sum('amount');
                return new Any([
                    'amount' => ($levelOneAmount + $levelTwoAmount)
                ]);
            });
            $amount =  ($revenue->incomes->sum('amount') + $children->sum('amount'));
            ($this->termly) ? TermlyAccrualRevenue::updateOrCreate(['term_id' => $this->term->id, 'account_id' => $revenue->id],['amount' => $amount, 'term_id' => $this->term->id, 'account_id' => $revenue->id]) : '';
        }
       }
        return $this;
    }
  
    public function getRevenue()
    {
        if($this->termly){
            $term = $this->term;
            return Revenue::with(['incomes' => function($incomeQuery) use ($term){
                $incomeQuery->ofTerm($term);
            }, 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes', 'children' => function($childrenQuery){
                    $childrenQuery->with(['incomes']);
                }]);
            }])->get();
        }
        $period = $this->period;
        return Revenue::with(['incomes' => function($incomeQuery) use ($period){
            $incomeQuery->ofPeriod($period);
        }, 'children' => function($childrenQuery){
            $childrenQuery->with(['incomes', 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes']);
            }]);
        }])->get();
    }

    public function getSingleRevenue($id)
    {
        if($this->termly){
            $term = $this->term;
            return Revenue::with(['incomes' => function($incomeQuery) use ($term){
                $incomeQuery->ofTerm($term);
            }, 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes', 'children' => function($childrenQuery){
                    $childrenQuery->with(['incomes']);
                }]);
            }])->whereId($id)->first();
        }
        $period = $this->period;
        return Revenue::with(['incomes' => function($incomeQuery) use($period){
            $incomeQuery->ofPeriod($period);
        }, 'children' => function($childrenQuery){
            $childrenQuery->with(['incomes', 'children' => function($childrenQuery){
                $childrenQuery->with(['incomes']);
            }]);
        }])->whereId($id)->first();
    }

    
}
