import axios from "axios";
import React, { useState, useEffect } from "react";
import toast, { Toaster } from "react-hot-toast";
import Swal from "sweetalert2";
import SuccessSound from "../sounds/beep-07a.mp3";
import WarningSound from "../sounds/beep-02.mp3";
import playSound from "../utils/playSound";

export default function Cart({ carts, setCartUpdated, cartUpdated }) {
    function increment(id) {
        axios
            .put("/admin/cart/increment", {
                id: id,
            })
            .then((res) => {
                setCartUpdated(!cartUpdated);
                playSound(SuccessSound);
                toast.success(res?.data?.message);
            })
            .catch((err) => {
                playSound(WarningSound);
                toast.error(err.response.data.message);
            });
    }
    function decrement(id) {
        axios
            .put("/admin/cart/decrement", {
                id: id,
            })
            .then((res) => {
                setCartUpdated(!cartUpdated);
                playSound(SuccessSound);
                toast.success(res?.data?.message);
            })
            .catch((err) => {
                playSound(WarningSound);
                toast.error(err.response.data.message);
            });
    }
    function destroy(id) {
        Swal.fire({
            title: "Remove Item?",
            text: "Are you sure you want to remove this item from your cart?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, remove",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#ef4444",
            cancelButtonColor: "#f1f5f9",
            reverseButtons: true,
            customClass: {
                popup: 'modern-swal-popup',
                title: 'modern-swal-title',
                htmlContainer: 'modern-swal-content'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .put("/admin/cart/delete", {
                        id: id,
                    })
                    .then((res) => {
                        console.log(res);
                        setCartUpdated(!cartUpdated);
                        playSound(SuccessSound);
                        toast.success(res?.data?.message);
                    })
                    .catch((err) => {
                        toast.error(err.response.data.message);
                    });
            } else if (result.isDenied) {
                return;
            }
        });
    }
    return (
        <>
            <div className="user-cart">
                <div className="card shadow-none border-0 overflow-hidden" style={{ borderRadius: '16px' }}>
                    <div className="card-body p-0">
                        <div className="table-responsive">
                            <table className="table mb-0">
                                <thead className="bg-light">
                                    <tr>
                                        <th className="border-0 py-3 pl-4 text-secondary" style={{ fontSize: '0.75rem', letterSpacing: '0.05em' }}>ITEM NAME</th>
                                        <th className="border-0 py-3 text-center text-secondary" style={{ fontSize: '0.75rem', letterSpacing: '0.05em' }}>QTY</th>
                                        <th className="border-0 py-3 text-right pr-4 text-secondary" style={{ fontSize: '0.75rem', letterSpacing: '0.05em' }}>PRICE & TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {carts.map((item) => (
                                        <tr key={item.id} className="align-middle">
                                            <td className="pl-4 py-3 align-middle">
                                                <div className="font-weight-bold mb-0" style={{ color: '#1e293b', fontSize: '0.95rem' }}>
                                                    {item.product.name}
                                                </div>
                                            </td>
                                            <td className="py-3 align-middle">
                                                <div className="d-flex align-items-center justify-content-center gap-2">
                                                    <button
                                                        className="btn btn-sm p-0 d-flex align-items-center justify-content-center"
                                                        style={{ width: '28px', height: '28px', backgroundColor: '#f1f5f9', color: '#64748b', borderRadius: '8px' }}
                                                        onClick={() => decrement(item.id)}
                                                    >
                                                        <i className="fas fa-minus fa-xs"></i>
                                                    </button>
                                                    
                                                    <div className="mx-2 font-weight-bold" style={{ width: '30px', textAlign: 'center', color: '#334155' }}>
                                                        {item.quantity}
                                                    </div>

                                                    <button
                                                        className="btn btn-sm p-0 d-flex align-items-center justify-content-center text-white"
                                                        style={{ width: '28px', height: '28px', backgroundColor: '#0ea5e9', borderRadius: '8px' }}
                                                        onClick={() => increment(item.id)}
                                                    >
                                                        <i className="fas fa-plus fa-xs"></i>
                                                    </button>

                                                    <button
                                                        className="btn btn-sm p-0 ml-3 text-danger d-flex align-items-center justify-content-center hover-opacity-7"
                                                        style={{ width: '28px', height: '28px', background: 'transparent' }}
                                                        onClick={() => destroy(item.id)}
                                                    >
                                                        <i className="fas fa-trash-alt fa-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td className="text-right pr-4 py-3 align-middle">
                                                <div className="font-weight-bold" style={{ color: '#0ea5e9', fontSize: '1rem' }}>
                                                    {item?.row_total}
                                                </div>
                                                <div className="text-muted" style={{ fontSize: '0.8rem' }}>
                                                    {item?.product?.discounted_price} x {item.quantity}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <Toaster position="top-right" reverseOrder={false} />
        </>
    );
}
