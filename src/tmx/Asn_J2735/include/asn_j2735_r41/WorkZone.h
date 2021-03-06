/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "DSRC"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_WorkZone_H_
#define	_WorkZone_H_


#include "asn_application.h"

/* Including external dependencies */
#include "asn_SEQUENCE_OF.h"
#include "ITIScodes.h"
#include "IA5String.h"
#include "constr_CHOICE.h"
#include "constr_SEQUENCE.h"
#include "constr_SEQUENCE_OF.h"

#ifdef __cplusplus
extern "C" {
#endif

/* Dependencies */
typedef enum item_wk_PR {
	item_wk_PR_NOTHING,	/* No components present */
	item_wk_PR_itis,
	item_wk_PR_text
} item_wk_PR;

/* WorkZone */
typedef struct WorkZone {
	A_SEQUENCE_OF(struct WorkZone__Member {
		struct item_wk {
			item_wk_PR present;
			union item_wk_u {
				ITIScodes_t	 itis;
				IA5String_t	 text;
			} choice;
			
			/* Context for parsing across buffer boundaries */
			asn_struct_ctx_t _asn_ctx;
		} item_wk;
		
		/* Context for parsing across buffer boundaries */
		asn_struct_ctx_t _asn_ctx;
	} ) list;
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} WorkZone_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_WorkZone;

#ifdef __cplusplus
}
#endif

#endif	/* _WorkZone_H_ */
#include "asn_internal.h"
